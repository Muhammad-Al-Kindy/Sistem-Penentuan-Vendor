<?php
// app/Http/Controllers/SmartController.php
namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use App\Models\Vendor;
use App\Models\Material;
use App\Models\PurchaseOrder;
use App\Models\VendorUpdate;
use Illuminate\Support\Facades\DB;

class SmartController extends Controller
{
    public function index(Request $request)
    {
        $selectedMaterialId = $request->query('material_id');

        $vendors = Vendor::paginate(10);
        $materials = Material::all();

        return view('admin.rekomendasi.index', [
            'vendors' => $vendors,
            'materials' => $materials,
            'selectedMaterialId' => $selectedMaterialId,
        ]);
    }

    public function process(Request $request)
    {
        // Ambil daftar vendor unik yang pernah ada di PO
        $vendors = Vendor::whereIn('idVendor', PurchaseOrder::pluck('vendorId'))->get();

        $matrix = [];
        $vendorNames = [];

        foreach ($vendors as $vendor) {
            $vendorNames[] = $vendor->namaVendor;

            // --- Delivery Time: rata-rata selisih tanggal_terima - tanggalPO
            $deliveryData = DB::table('purchase_orders as po')
                ->join('goods_receipts as gr', 'gr.purchaseOrderId', '=', 'po.idPurchaseOrder')
                ->where('po.vendorId', $vendor->id)
                ->select(DB::raw('DATEDIFF(gr.tanggal_terima, po.tanggalPO) as delivery_days'))
                ->get();
            $deliveryAvg = $deliveryData->avg('delivery_days') ?? 0;

            // --- Kualitas: rata-rata qty_sesuai / qty_po
            $kualitasData = DB::table('goods_receipts_items as gri')
                ->join('goods_receipts as gr', 'gri.goodsReceiptId', '=', 'gr.idGoodsReceipt')
                ->where('gr.vendor_id', $vendor->id)
                ->select(DB::raw('IFNULL(qty_sesuai / NULLIF(qty_po, 0), 0) as kualitas'))
                ->get();
            $kualitasAvg = $kualitasData->avg('kualitas') ?? 0;

            // --- Respon NC: rata-rata waktu respon (selisih menit)
            $responWaktu = 0;
            $responCount = 0;
            $ncGrouped = ChatMessage::where('to_id', $vendor->id)->orWhere('from_id', $vendor->id)
                ->get()
                ->groupBy('non_conformance_id');

            foreach ($ncGrouped as $messages) {
                $adminMsg = $messages->where('from_id', 1)->sortBy('created_at')->first();
                $vendorMsg = $messages->where('from_id', $vendor->id)->sortBy('created_at')->first();

                if ($adminMsg && $vendorMsg) {
                    $diff = abs(strtotime($vendorMsg->created_at) - strtotime($adminMsg->created_at));
                    $responWaktu += $diff / 60; // in minutes
                    $responCount++;
                }
            }
            $responAvg = $responCount > 0 ? $responWaktu / $responCount : 0;

            // --- Monitoring: jumlah update Progress
            $monitoringCount = VendorUpdate::where('vendor_id', $vendor->id)
                ->where('jenis_update', 'Progress')
                ->count();

            // --- Pembatalan: 1 jika ada jenis_update Dibatalkan, 0 jika tidak
            $batalCount = VendorUpdate::where('vendor_id', $vendor->id)
                ->where('jenis_update', 'Dibatalkan')
                ->count();
            $batalScore = $batalCount > 0 ? 1 : 0;

            $matrix[] = [
                round($deliveryAvg, 2),
                round($kualitasAvg, 2),
                round($responAvg, 2),
                round($monitoringCount, 2),
                round($batalScore, 2),
            ];
        }

        if (collect($matrix)->flatten()->sum() == 0) {
            Log::debug('SMART process result:', $matrix);

            return redirect()->route('rekomendasi.index')->with('error', 'Data vendor belum lengkap untuk dilakukan perhitungan.');
        }

        // --- Nilai bobot dan jenis subkriteria
        $weights = [0.25, 0.25, 0.2, 0.2, 0.1]; // bisa disesuaikan
        $types = [1, 1, 1, 1, -1]; // cost/benefit

        $subcriteria = ['delivery_time', 'kualitas', 'respon_nc', 'monitoring', 'pembatalan'];

        // Cegah pembagian nol
        $columnSums = array_fill(0, count($matrix[0]), 0);
        foreach ($matrix as $row) {
            foreach ($row as $i => $val) {
                $columnSums[$i] += $val;
            }
        }
        foreach ($columnSums as $i => $sum) {
            if ($sum == 0) $columnSums[$i] = 1;
        }
        $normMatrix = [];
        foreach ($matrix as $row) {
            $normRow = [];
            foreach ($row as $i => $val) {
                $normRow[] = $val / $columnSums[$i];
            }
            $normMatrix[] = $normRow;
        }

        // Jalankan Python SMART
        $pythonPath = 'C:\\Python312\\python.exe';
        $scriptPath = base_path('resources/python/smart_mode_args.py');

        $process = new Process([
            $pythonPath,
            $scriptPath,
            '--matrix',
            json_encode($normMatrix),
            '--weights',
            json_encode($weights),
            '--types',
            json_encode($types),
            '--subcriteria',
            json_encode($subcriteria),
        ], dirname($scriptPath));

        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("Python SMART Error: " . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $result = json_decode($process->getOutput(), true);
        $result['vendor_names'] = $vendorNames;
        $result['matrix'] = $matrix;

        Log::debug('SMART process result:', $result);

        $vendors = Vendor::paginate(10);
        $materials = Material::all();
        $selectedMaterialId = $request->input('material_id');

        return view('admin.rekomendasi.index', compact('result', 'vendors', 'materials', 'selectedMaterialId'));
    }
}