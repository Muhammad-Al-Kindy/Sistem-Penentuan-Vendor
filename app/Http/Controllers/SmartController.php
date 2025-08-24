<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Material;
use App\Models\Vendor;
use App\Models\VendorUpdate;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SmartController extends Controller
{
    public function index(Request $request)
    {
        $selectedMaterialId = $request->query('material_id');
        $materials = Material::all();

        $vendors = $selectedMaterialId
            ? Vendor::whereIn('idVendor', function ($q) use ($selectedMaterialId) {
                $q->select('po.vendorId')
                    ->from('purchase_orders as po')
                    ->join('purchase_order_items as poi', 'poi.purchaseOrderId', '=', 'po.idPurchaseOrder')
                    ->where('poi.materialId', $selectedMaterialId);
            })->paginate(10)->appends(['material_id' => $selectedMaterialId])
            : Vendor::paginate(10);

        return view('admin.rekomendasi.index', compact('vendors', 'materials', 'selectedMaterialId'));
    }

    public function process(Request $request)
    {
        $materialId = $request->input('material_id');

        $vendors = Vendor::whereIn('idVendor', function ($q) use ($materialId) {
            $q->select('po.vendorId')
                ->from('purchase_orders as po')
                ->join('purchase_order_items as poi', 'poi.purchaseOrderId', '=', 'po.idPurchaseOrder')
                ->where('poi.materialId', $materialId);
        })->get();

        $matrix = [];
        $vendorNames = [];

        foreach ($vendors as $vendor) {
            $vendorNames[] = $vendor->namaVendor;

            $poList = DB::table('purchase_orders as po')
                ->join('purchase_order_items as poi', 'po.idPurchaseOrder', '=', 'poi.purchaseOrderId')
                ->where('po.vendorId', $vendor->idVendor)
                ->where('poi.materialId', $materialId)
                ->select('po.idPurchaseOrder')
                ->distinct()
                ->pluck('po.idPurchaseOrder');

            $deliveryScores = [];
            $monitoringScores = [];
            $kualitasScores = [];
            $responScores = [];
            $batalScores = [];

            foreach ($poList as $poId) {
                // DELIVERY TIME per PO
                $deliveryAvg = DB::table('purchase_order_items as poi')
                    ->join('goods_receipts as gr', 'gr.purchaseOrderId', '=', 'poi.purchaseOrderId')
                    ->where('poi.purchaseOrderId', $poId)
                    ->where('poi.materialId', $materialId)
                    ->select(DB::raw('DATEDIFF(gr.tanggal_terima, poi.batasDiterima) as delivery_days'))
                    ->pluck('delivery_days')
                    ->filter()
                    ->avg();

                if ($deliveryAvg !== null) {
                    $deliveryAvg = (float) $deliveryAvg;
                    $deliveryScores[] = match (true) {
                        $deliveryAvg <= 0 => $this->getSubKriteriaScore(1, 'Tepat waktu atau lebih cepat'),
                        $deliveryAvg <= 14 => $this->getSubKriteriaScore(1, 'Terlambat 1–14 hari'),
                        default => $this->getSubKriteriaScore(1, 'Terlambat >14 hari'),
                    };
                }

                // MONITORING per PO
                $monitoringCount = DB::table('vendor_updates')
                    ->where('purchase_order_id', $poId)
                    ->where('vendor_id', $vendor->idVendor)
                    ->where('jenis_update', 'Progress')
                    ->count();

                $monitoringScores[] = match (true) {
                    $monitoringCount >= 3 => $this->getSubKriteriaScore(2, 'Respon Baik'),
                    $monitoringCount == 2 => $this->getSubKriteriaScore(2, 'Respon Cukup'),
                    $monitoringCount == 1 => $this->getSubKriteriaScore(2, 'Respon Buruk'),
                    default => 0,
                };

                // KUALITAS per PO
                $kualitas = DB::table('goods_receipts_items as gri')
                    ->join('goods_receipts as gr', 'gri.goodsReceiptId', '=', 'gr.idGoodsReceipt')
                    ->where('gr.purchaseOrderId', $poId)
                    ->where('gri.materialId', $materialId)
                    ->select(DB::raw('IFNULL(CAST(gri.qty_sesuai AS DECIMAL(10,2)) / NULLIF(CAST(gri.qty_po AS DECIMAL(10,2)), 0), 0) as kualitas'))
                    ->pluck('kualitas')
                    ->avg();

                if ($kualitas !== null) {
                    $kualitasScores[] = match (true) {
                        $kualitas >= 1 => $this->getSubKriteriaScore(3, 'Sangat Baik (100%)'),
                        $kualitas >= 0.81 => $this->getSubKriteriaScore(3, 'Cukup (81%–99%)'),
                        default => $this->getSubKriteriaScore(3, 'Kurang (<80%)'),
                    };
                }

                // RESPON NC per PO
                $vendorUserId = $vendor->user_id;
                $ncIds = DB::table('non_conformances')
                    ->join('goods_receipts_items as gri', 'gri.idGoodReceiptsItem', '=', 'non_conformances.goods_receipt_item_id')
                    ->join('goods_receipts as gr', 'gr.idGoodsReceipt', '=', 'gri.goodsReceiptId')
                    ->where('gr.purchaseOrderId', $poId)
                    ->where('gri.materialId', $materialId)
                    ->pluck('non_conformances.idNonConformance');

                $ncGrouped = ChatMessage::where(function ($q) use ($vendorUserId) {
                    $q->where('to_id', $vendorUserId)->orWhere('from_id', $vendorUserId);
                })
                    ->whereIn('non_conformance_id', $ncIds)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy('non_conformance_id');

                $responWaktu = 0;
                $responCount = 0;

                foreach ($ncGrouped as $messages) {
                    $adminMsg = $messages->firstWhere('from_id', 1);
                    $vendorMsg = $messages
                        ->where('from_id', $vendorUserId)
                        ->filter(fn($msg) => $adminMsg && $msg->created_at > $adminMsg->created_at)
                        ->sortBy('created_at')
                        ->first();

                    if ($adminMsg && $vendorMsg) {
                        $diff = strtotime($vendorMsg->created_at) - strtotime($adminMsg->created_at);
                        $responWaktu += $diff / 60;
                        $responCount++;
                    }
                }

                if ($responCount > 0) {
                    $avgRespon = $responWaktu / $responCount;
                    $responScores[] = match (true) {
                        $avgRespon <= 60 * 24 => $this->getSubKriteriaScore(4, 'Respon 1 hari'),
                        $avgRespon <= 60 * 72 => $this->getSubKriteriaScore(4, 'Respon 3 hari'),
                        default => $this->getSubKriteriaScore(4, 'Respon >5 hari'),
                    };
                }

                // PEMBATALAN per PO
                $batalUpdate = VendorUpdate::where('vendor_id', $vendor->idVendor)
                    ->where('purchase_order_id', $poId)
                    ->where('jenis_update', 'Dibatalkan')
                    ->orderByDesc('created_at')
                    ->first();

                if ($batalUpdate) {
                    $ket = strtolower($batalUpdate->keterangan ?? '');
                    $batalScores[] = match (true) {
                        str_contains($ket, 'reka') => $this->getSubKriteriaScore(5, 'Karena pertimbangan REKA'),
                        str_contains($ket, 'buruk') => $this->getSubKriteriaScore(5, 'Karena Respon Vendor yang buruk'),
                        default => $this->getSubKriteriaScore(5, 'Karena Vendor Gagal memenuhi kewajibannya'),
                    };
                }
            }

            $matrix[] = [
                collect($deliveryScores)->avg() ?? 0,
                collect($monitoringScores)->avg() ?? 0,
                collect($kualitasScores)->avg() ?? 0,
                collect($responScores)->avg() ?? 0,
                collect($batalScores)->avg() ?? 0,
            ];
        }

        $weights = [0.25, 0.2, 0.25, 0.2, 0.1];
        $types = [1, 1, 1, 1, -1];
        $subcriteria = ['delivery_time', 'monitoring', 'kualitas', 'respon_nc', 'pembatalan'];

        $data = compact('matrix', 'weights', 'types', 'subcriteria');

        $process = new Process([
            'C:\\Python312\\python.exe',
            base_path('resources/python/smart_mode_args.py'),
            '--json',
            json_encode($data)
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            Log::error('SMART Python error', ['error' => $process->getErrorOutput()]);
            throw new ProcessFailedException($process);
        }

        $result = json_decode($process->getOutput(), true);
        $result['vendor_names'] = $vendorNames;
        $result['matrix'] = $matrix;

        $ranking = collect($result['scores'])
            ->map(fn($score, $i) => ['index' => $i, 'score' => $score])
            ->sortByDesc('score')
            ->values()
            ->mapWithKeys(fn($item, $rank) => [$item['index'] => $rank + 1]);

        $result['ranking'] = array_map(fn($i) => $ranking[$i], array_keys($result['scores']));
        $scoredVendors = collect($vendors)
            ->map(function ($vendor, $i) use ($result) {
                return [
                    'vendor' => $vendor,
                    'score' => $result['scores'][$i] ?? 0,
                    'ranking' => $result['ranking'][$i] ?? null,
                ];
            })
            ->sortBy('ranking')
            ->values();


        return view('admin.rekomendasi.index', [
            'result' => $result,
            'vendors' => $vendors,
            'scoredVendors' => $scoredVendors,
            'materials' => Material::all(),
            'selectedMaterialId' => $materialId,
        ]);
    }

    private function getSubKriteriaScore($kriteriaId, $namaSubKriteria)
    {
        $sub = SubKriteria::where('kriteriaId', $kriteriaId)
            ->whereRaw('LOWER(namaSubKriteria) = ?', [strtolower($namaSubKriteria)])
            ->first();

        if (!$sub) {
            Log::warning("Subkriteria not found", [
                'kriteriaId' => $kriteriaId,
                'namaSubKriteria' => $namaSubKriteria
            ]);
        }

        return $sub->skorSubKriteria ?? 0;
    }
}