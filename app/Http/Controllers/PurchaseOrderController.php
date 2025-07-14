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

        $order = PurchaseOrder::with('vendor.contacts')->when($search, function ($query, $search) {
            $query->whereHas('vendor', function ($query) use ($search) {
                $query->where('namaVendor', 'like', "%{$search}%");
            });
        })->paginate(10);

        return view('purchase_order.index', compact('order'));
    }

    public function getMaterialVendorPrices(Request $request)
    {
        $materialId = $request->query('materialId');
        $vendorId = $request->query('vendorId');

        if (!$materialId || !$vendorId) {
            return response()->json(['error' => 'materialId and vendorId are required'], 400);
        }

        $prices = MaterialVendorPrice::where('materialId', $materialId)
            ->where('vendorId', $vendorId)
            ->get();

        return response()->json($prices);
    }

    public function create()
    {
        $vendors = Vendor::all();
        $materials = Material::all();
        $materialVendorPrices = MaterialVendorPrice::all();
        $rfqs = \App\Models\Rfqs::all();
        $purchaseOrders = PurchaseOrder::all();
        $purchaseOrderItems = \App\Models\PurchaseOrderItem::all();
        return view('purchase_order.add', compact('vendors', 'materials', 'materialVendorPrices', 'rfqs', 'purchaseOrders', 'purchaseOrderItems'));
    }

    public function getItems($purchaseOrderId)
    {
        try {
            $items = \App\Models\PurchaseOrderItem::where('purchaseOrderId', $purchaseOrderId)->with('item')->get();
            return response()->json($items);
        } catch (\Exception $e) {
            Log::error('Error fetching purchase order items: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch items'], 500);
        }
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
            'items.*.batasDiterima' => 'nullable|date',
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
                $hargaPerUnit = $materialVendorPrice->harga;
                $mataUang = $materialVendorPrice->mataUang;
                $vat = $materialVendorPrice->vat ?? 0;
                $kuantitas = $item['kuantitas'];
                $total = $hargaPerUnit * $kuantitas;

                $purchaseOrder->items()->create([
                    'materialId' => $item['materialId'],
                    'materialVendorPriceId' => $materialVendorPrice->idMaterialVendorPrice,
                    'kuantitas' => $kuantitas,
                    'hargaPerUnit' => $hargaPerUnit,
                    'mataUang' => $mataUang,
                    'vat' => $vat,
                    'batasDiterima' => $item['batasDiterima'] ?? null,
                    'total' => $total,
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Purchase order berhasil ditambahkan.', 'purchaseOrder' => $purchaseOrder]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan purchase order.'], 500);
        }
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items');
        $vendors = Vendor::all();
        $materials = Material::all();
        $materialVendorPrices = MaterialVendorPrice::all();
        $initialItems = $purchaseOrder->items->map(function ($item) {
            return [
                'id' => $item->idPurchaseOrderItem,
                'materialId' => $item->materialId,
                'materialVendorPriceId' => $item->materialVendorPriceId,
                'kuantitas' => $item->kuantitas,
                'mataUang' => $item->mataUang,
                'vat' => $item->vat,
                'batasDiterima' => $item->batasDiterima,
            ];
        });
        $initialVendorId = $purchaseOrder->vendor->idVendor ?? null;

        return view('purchase_order.edit', compact('purchaseOrder', 'vendors', 'materials', 'materialVendorPrices', 'initialItems', 'initialVendorId'));
    }

    public function update(Request $request, $id)
    {
        if ($request->header('Content-Type') === 'application/json') {
            $data = json_decode($request->getContent(), true);
            $request->replace($data); // Ini lebih aman daripada merge
        }


        $validatedData = $request->validate([
            'vendorId' => 'required|exists:vendors,idVendor',
            'noPO' => 'required|string|max:255',
            'tanggalPO' => 'required|date',
            'noKontrak' => 'nullable|string|max:255',
            'noRevisi' => 'nullable|string|max:255',
            'tanggalRevisi' => 'nullable|date',
            'incoterm' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:purchase_order_items,idPurchaseOrderItem',
            'items.*.materialId' => 'required|exists:materials,idMaterial',
            'items.*.materialVendorPriceId' => 'required|exists:material_vendor_prices,idMaterialVendorPrice',
            'items.*.kuantitas' => 'required|numeric|min:1',
            'items.*.batasDiterima' => 'nullable|date',
        ]);

        // dd($validatedData);

        DB::beginTransaction();

        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            // Convert empty strings to null for nullable date fields
            $tanggalPO = $validatedData['tanggalPO'] !== '' ? $validatedData['tanggalPO'] : null;
            $tanggalRevisi = $validatedData['tanggalRevisi'] !== '' ? $validatedData['tanggalRevisi'] : null;
            $noRevisi = $validatedData['noRevisi'] !== '' ? $validatedData['noRevisi'] : null;
            $noKontrak = $validatedData['noKontrak'] !== '' ? $validatedData['noKontrak'] : null;
            $incoterm = $validatedData['incoterm'] !== '' ? $validatedData['incoterm'] : null;

            $purchaseOrder->update([
                'vendorId' => $validatedData['vendorId'],
                'noPO' => $validatedData['noPO'],
                'tanggalPO' => $tanggalPO,
                'noKontrak' => $noKontrak,
                'noRevisi' => $noRevisi,
                'tanggalRevisi' => $tanggalRevisi,
                'incoterm' => $incoterm,
            ]);

            foreach ($validatedData['items'] as $itemData) {
                $materialVendorPrice = MaterialVendorPrice::findOrFail($itemData['materialVendorPriceId']);
                $hargaPerUnit = $materialVendorPrice->harga;
                $mataUang = $materialVendorPrice->mataUang;
                $vat = $materialVendorPrice->vat ?? 0;
                $total = $hargaPerUnit * $itemData['kuantitas'];

                if (!empty($itemData['id'])) {
                    $item = \App\Models\PurchaseOrderItem::findOrFail($itemData['id']);
                    $item->update([
                        'materialId' => $itemData['materialId'],
                        'materialVendorPriceId' => $materialVendorPrice->idMaterialVendorPrice,
                        'kuantitas' => $itemData['kuantitas'],
                        'hargaPerUnit' => $hargaPerUnit,
                        'mataUang' => $mataUang,
                        'vat' => $vat,
                        'batasDiterima' => $itemData['batasDiterima'],
                        'total' => $total,
                    ]);
                } else {
                    $purchaseOrder->items()->create([
                        'materialId' => $itemData['materialId'],
                        'materialVendorPriceId' => $materialVendorPrice->idMaterialVendorPrice,
                        'kuantitas' => $itemData['kuantitas'],
                        'hargaPerUnit' => $hargaPerUnit,
                        'mataUang' => $mataUang,
                        'vat' => $vat,
                        'batasDiterima' => $itemData['batasDiterima'],
                        'total' => $total,
                    ]);
                }
            }

            DB::commit();
            Log::info('DATA MASUK:', $request->all());


            return response()->json(['success' => true, 'message' => 'Purchase order berhasil diperbarui.', 'purchaseOrder' => $purchaseOrder]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui purchase order.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->delete();
            return redirect()->route('purchase.index')->with('success', 'Purchase order berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete purchase order: ' . $e->getMessage());
            return redirect()->route('purchase.index')->with('error', 'Gagal menghapus purchase order.');
        }
    }
}
