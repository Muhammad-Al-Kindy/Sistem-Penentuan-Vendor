<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Material;
use App\Models\PurchaseOrder;
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
        $vendors = Vendor::paginate(10);
        $materials = Material::all();

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

            $poIds = DB::table('purchase_orders as po')
                ->join('purchase_order_items as poi', 'po.idPurchaseOrder', '=', 'poi.purchaseOrderId')
                ->where('po.vendorId', $vendor->idVendor)
                ->where('poi.materialId', $materialId)
                ->pluck('po.idPurchaseOrder');

            // DELIVERY TIME
            $deliveryAvg = DB::table('purchase_order_items as poi')
                ->join('purchase_orders as po', 'poi.purchaseOrderId', '=', 'po.idPurchaseOrder')
                ->join('goods_receipts as gr', 'gr.purchaseOrderId', '=', 'po.idPurchaseOrder')
                ->whereIn('po.idPurchaseOrder', $poIds)
                ->select(DB::raw('DATEDIFF(gr.tanggal_terima, poi.batasDiterima) as delivery_days'))
                ->get()
                ->avg('delivery_days');

            $deliveryScore = 0;
            if ($deliveryAvg !== null) {
                $deliveryScore = match (true) {
                    $deliveryAvg <= 0 => $this->getSubKriteriaScore(1, 'Tepat waktu atau lebih cepat'),
                    $deliveryAvg <= 14 => $this->getSubKriteriaScore(1, 'Terlambat 1-14 hari'),
                    default => $this->getSubKriteriaScore(1, 'Terlambat >14 hari'),
                };
            }

            // MONITORING
            $monitoringCount = DB::table('vendor_updates')
                ->whereIn('purchase_order_id', $poIds)
                ->where('vendor_id', $vendor->idVendor)
                ->where('jenis_update', 'Progress')
                ->count();

            $monitoringScore = match (true) {
                $monitoringCount >= 3 => $this->getSubKriteriaScore(2, 'Respon Baik'),
                $monitoringCount == 2 => $this->getSubKriteriaScore(2, 'Respon Cukup'),
                $monitoringCount == 1 => $this->getSubKriteriaScore(2, 'Respon Buruk'),
                default => 0,
            };

            // KUALITAS
            $kualitasAvg = DB::table('goods_receipts_items as gri')
                ->join('goods_receipts as gr', 'gri.goodsReceiptId', '=', 'gr.idGoodsReceipt')
                ->whereIn('gr.purchaseOrderId', $poIds)
                ->where('gri.materialId', $materialId)
                ->select(DB::raw('IFNULL(CAST(gri.qty_sesuai AS DECIMAL(10,2)) / NULLIF(CAST(gri.qty_po AS DECIMAL(10,2)), 0), 0) as kualitas'))
                ->get()
                ->avg('kualitas');

            Log::info('AVG Kualitas', ['value' => $kualitasAvg]);

            $kualitasScore = 0;
            if ($kualitasAvg !== null) {
                $kualitasScore = match (true) {
                    $kualitasAvg >= 1 => $this->getSubKriteriaScore(3, 'Sangat Baik (100%)'),
                    $kualitasAvg >= 0.81 => $this->getSubKriteriaScore(3, 'Cukup (81%–99%)'), // benar
                    default => $this->getSubKriteriaScore(3, 'Kurang (<80%)'),
                };
            }



            // RESPON NC (berdasarkan material dan vendor)
            // RESPON NC (berdasarkan material dan vendor user_id)
            $responWaktu = 0;
            $responCount = 0;

            // Ambil user_id dari vendor
            $vendorUserId = $vendor->user_id; // pastikan kolom ini ada di tabel vendors

            // Ambil semua NC ID berdasarkan material
            $ncIds = DB::table('non_conformances')
                ->join('goods_receipts_items as gri', 'gri.idGoodReceiptsItem', '=', 'non_conformances.goods_receipt_item_id')
                ->where('gri.materialId', $materialId)
                ->pluck('non_conformances.idNonConformance');

            // Ambil semua chat yang relevan berdasarkan user_id vendor & NC ID
            $ncGrouped = ChatMessage::where(function ($query) use ($vendorUserId) {
                $query->where('to_id', $vendorUserId)
                    ->orWhere('from_id', $vendorUserId);
            })
                ->whereIn('non_conformance_id', $ncIds)
                ->orderBy('created_at')
                ->get()
                ->groupBy('non_conformance_id');

            // Proses tiap grup NC
            foreach ($ncGrouped as $ncId => $messages) {
                // Temukan pesan pertama dari admin (from_id = 1)
                $adminMsg = $messages->firstWhere('from_id', 1);

                // Temukan pesan vendor pertama setelah adminMsg
                $vendorMsg = $messages
                    ->where('from_id', $vendorUserId)
                    ->filter(fn($msg) => $adminMsg && $msg->created_at > $adminMsg->created_at)
                    ->sortBy('created_at')
                    ->first();

                // Jika ada kedua pesan, hitung selisih waktunya
                if ($adminMsg && $vendorMsg) {
                    $diff = strtotime($vendorMsg->created_at) - strtotime($adminMsg->created_at);
                    $responWaktu += $diff / 60; // dalam menit
                    $responCount++;

                    Log::info('NC ID', ['id' => $ncId]);
                    Log::info('Admin Msg', ['msg' => $adminMsg]);
                    Log::info('Vendor Msg', ['msg' => $vendorMsg]);
                }
            }

            // Hitung skor respon NC
            $responScore = 0;
            if ($responCount > 0) {
                $responAvg = $responWaktu / $responCount;
                $responScore = match (true) {
                    $responAvg <= 60 * 24 => $this->getSubKriteriaScore(4, 'Respon 1 hari'),
                    $responAvg <= 60 * 72 => $this->getSubKriteriaScore(4, 'Respon 3 hari'),
                    default => $this->getSubKriteriaScore(4, 'Respon >5 hari'),
                };
            }
            // PEMBATALAN
            $batalUpdate = VendorUpdate::where('vendor_id', $vendor->idVendor)
                ->whereIn('purchase_order_id', $poIds)
                ->where('jenis_update', 'Dibatalkan')
                ->orderByDesc('created_at')
                ->first();

            $batalScore = 0;
            if ($batalUpdate) {
                switch ($batalUpdate->keterangan) {
                    case 'reka':
                        $batalScore = $this->getSubKriteriaScore(5, 'Karena pertimbangan REKA');
                        break;
                    case 'buruk':
                        $batalScore = $this->getSubKriteriaScore(5, 'Karena Respon Vendor yang buruk');
                        break;
                    case 'gagal':
                        $batalScore = $this->getSubKriteriaScore(5, 'Karena Vendor Gagal memenuhi kewajibannya');
                        break;
                }
            }

            $matrix[] = [$deliveryScore, $monitoringScore, $kualitasScore, $responScore, $batalScore];
        }

        if (empty($matrix)) {
            Log::warning('SMART: Matrix kosong, proses dihentikan');
            return redirect()->back()->with('error', 'Data penilaian vendor tidak tersedia.');
        }

        $weights = [0.25, 0.2, 0.25, 0.2, 0.1];
        $types = [1, 1, 1, 1, -1];
        $subcriteria = ['delivery_time', 'monitoring', 'kualitas', 'respon_nc', 'pembatalan'];

        $pythonPath = 'C:\\Python312\\python.exe';
        $scriptPath = base_path('resources/python/smart_mode_args.py');

        $data = [
            'matrix' => $matrix,
            'weights' => $weights,
            'types' => $types,
            'subcriteria' => $subcriteria,
        ];

        $process = new Process([
            $pythonPath,
            $scriptPath,
            '--json',
            json_encode($data)
        ], dirname($scriptPath));

        $process->run();

        if (!$process->isSuccessful()) {
            Log::error('SMART Python error', ['error' => $process->getErrorOutput()]);
            throw new ProcessFailedException($process);
        }

        $result = json_decode($process->getOutput(), true);
        $result['vendor_names'] = $vendorNames;
        $result['matrix'] = $matrix;

        return view('admin.rekomendasi.index', [
            'result' => $result,
            'vendors' => Vendor::paginate(10),
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