<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Models\Material;
use App\Models\MaterialVendorPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $order = PurchaseOrder::when($search, function ($query, $search) {
            $query->whereHas('vendor', function ($query) use ($search) {
                $query->where('namaVendor', 'like', "%{$search}%");
            });
        })->paginate(10); // Show 10 per page

        return view('purchase_order.index', compact('order'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $materials = Material::all();
        $materialVendorPrices = MaterialVendorPrice::all();
        return view('purchase_order.add', compact('vendors', 'materials', 'materialVendorPrices'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vendorId' => 'required|exists:vendors,idVendor',
            'noPO' => 'required|string|max:255',
            'tanggalPO' => 'required|date',
            'noKontrak' => 'nullable|string|max:255',
            'noRevisi' => 'nullable|string|max:255',
            'tanggalRevisi' => 'nullable|date',
            'incoterm' => 'nullable|string|max:255',
            'created_by' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.materialId' => 'required|exists:materials,idMaterial',
            'items.*.materialVendorPriceId' => 'required|exists:material_vendor_prices,idMaterialVendorPrice',
            'items.*.kuantitas' => 'required|numeric|min:1',
            'items.*.hargaPerUnit' => 'required|numeric|min:0',
            'items.*.mataUang' => 'required|string|max:10',
            'items.*.vat' => 'nullable|numeric|min:0',
            'items.*.batasDiterima' => 'nullable|date',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $purchaseOrder = PurchaseOrder::create([
                'vendorId' => $validatedData['vendorId'],
                'noPO' => $validatedData['noPO'],
                'tanggalPO' => $validatedData['tanggalPO'],
                'noKontrak' => $validatedData['noKontrak'] ?? null,
                'noRevisi' => $validatedData['noRevisi'] ?? null,
                'tanggalRevisi' => $validatedData['tanggalRevisi'] ?? null,
                'incoterm' => $validatedData['incoterm'] ?? null,
                'created_by' => $validatedData['created_by'] ?? null,
            ]);

            foreach ($validatedData['items'] as $item) {
                $materialVendorPrice = MaterialVendorPrice::findOrFail($item['materialVendorPriceId']);
                $purchaseOrder->items()->create([
                    'materialId' => $item['materialId'],
                    'materialVendorPriceId' => $materialVendorPrice->idMaterialVendorPrice,
                    'kuantitas' => $item['kuantitas'],
                    'hargaPerUnit' => $item['hargaPerUnit'],
                    'mataUang' => $item['mataUang'],
                    'vat' => isset($item['vat']) ? $item['vat'] : 0,
                    'batasDiterima' => !empty($item['batasDiterima']) ? $item['batasDiterima'] : null,
                    'total' => $item['total'],
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Purchase order berhasil ditambahkan.',
                    'purchaseOrder' => $purchaseOrder,
                ]);
            }

            return redirect()->route('purchase.index')->with('status', 'stored');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan purchase order.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withErrors('Gagal menambahkan purchase order: ' . $e->getMessage());
        }
    }

    public function show(PurchaseOrder $vendors)
    {
        return view('vendors.show', compact('vendors'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items.item'); // eager load items and related materials
        $vendor = $purchaseOrder->vendor; // get related vendor
        return view('purchase_order.edit', compact('purchaseOrder', 'vendor'));
    }

    public function update(Request $request)
    {
        // Fix undefined variable $vendors by retrieving the PurchaseOrder instance first
        $purchaseOrder = PurchaseOrder::findOrFail($request->id);
        $purchaseOrder->update($request->all());
        return redirect()->route('purchase.index')->with('success', 'Purchase order berhasil diperbarui.');
    }

    public function destroy(PurchaseOrder $vendors)
    {
        $vendors->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendors berhasil dihapus.');
    }
}