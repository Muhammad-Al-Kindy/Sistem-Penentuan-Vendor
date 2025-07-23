<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialVendorPrice;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Models\VendorUpdate;
use Illuminate\Http\Request;

class VendorUpdateController extends Controller
{
    /**
     * Display a listing of the vendor updates.
     */
    public function index()
    {
        $user = auth()->user();
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Unauthorized: No vendor associated with user.');
        }

        $purchaseOrders = \App\Models\PurchaseOrder::where('vendorId', $vendor->idVendor)
            ->with('vendorUpdates')
            ->orderBy('tanggalPO', 'desc')
            ->paginate(10);

        return view('vendor.purchase_order', compact('purchaseOrders'));
    }

    /**
     * Display purchase orders for the logged-in vendor.
     */
    public function purchaseOrder()
    {
        $user = auth()->user();
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Unauthorized: No vendor associated with user.');
        }

        $purchaseOrders = \App\Models\PurchaseOrder::where('vendorId', $vendor->idVendor)
            ->with('vendorUpdates')
            ->orderBy('tanggalPO', 'desc')
            ->paginate(10);

        return view('vendor.purchase_order', compact('purchaseOrders'));
    }


    /**
     * Display the specified vendor update.
     */
    public function show(VendorUpdate $vendorUpdate)
    {
        return view('vendor_updates.show', compact('vendorUpdate'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['items', 'vendor']);
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

        // Load vendor update related to this purchase order (assuming one latest)
        $vendorUpdate = \App\Models\VendorUpdate::where('purchase_order_id', $purchaseOrder->idPurchaseOrder)->latest('tanggal_update')->first();

        // Pass additional data for Alpine.js component and vendorUpdate
        return view('vendor.purchase_order_edit', compact('purchaseOrder', 'vendors', 'materials', 'materialVendorPrices', 'initialItems', 'initialVendorId', 'vendorUpdate'));
    }

    /**
     * Store a newly created vendor update in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,idPurchaseOrder',
            'vendor_id' => 'required|exists:vendors,idVendor',
            'tanggal_update' => 'required|date',
            'jenis_update' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // validasi file
        ]);

        // Jika ada file yang diupload
        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('dokumen', 'public'); // simpan ke storage/app/public/dokumen
            $validated['dokumen'] = $path;
        }

        VendorUpdate::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Vendor update created successfully.']);
        }

        return redirect()->back()->with('success', 'Vendor update created successfully.');
    }

    /**
     * Update the specified vendor update in storage.
     */
    public function update(Request $request, VendorUpdate $vendorUpdate)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,idPurchaseOrder',
            'vendor_id' => 'required|exists:vendors,idVendor',
            'tanggal_update' => 'required|date',
            'jenis_update' => 'required|string|max:255',
            'dokumen' => 'nullable|string|max:255',
        ]);

        $vendorUpdate->update($validated);

        return redirect()->route('vendor_updates.index')->with('success', 'Vendor update updated successfully.');
    }

    public function reports()
    {
        $user = auth()->user();

        // Assuming vendor is related to user via user_id
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Unauthorized: No vendor associated with user.');
        }

        $nonConformances = \App\Models\NonConformance::whereHas('goodsReceiptItem.goodsReceipt', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->idVendor);
        })->orderBy('tanggal_ditemukan', 'desc')->paginate(10);

        return view('vendor.reports', compact('nonConformances'));
    }

    /**
     * Remove the specified vendor update from storage.
     */
    public function destroy(VendorUpdate $vendorUpdate)
    {
        $vendorUpdate->delete();

        return redirect()->route('vendor_updates.index')->with('success', 'Vendor update deleted successfully.');
    }
}