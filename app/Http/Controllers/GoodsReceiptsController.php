<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipts;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoodsReceiptsController extends Controller
{
    public function index()
    {
        $receipts = GoodsReceipts::with(['purchaseOrder.vendor', 'items'])->paginate(10);
        return view('kelola_kedatangan.index', compact('receipts'));
    }

    public function kelolaKedatanganIndex()
    {
        $receipts = GoodsReceipts::with(['purchaseOrder.vendor', 'items'])->paginate(10);
        return view('kelola_kedatangan.index', compact('receipts'));
    }

    public function create()
    {
        $orders = PurchaseOrder::all();
        return view('goods_receipts.create', compact('orders'));
    }

    public function kelolaKedatanganAdd()
    {
        $orders = PurchaseOrder::all();
        return view('kelola_kedatangan.add', compact('orders'));
    }

    public function store(Request $request)
    {
        Log::info('Store method called with data:', $request->all());

        $request->validate([
            'no_dokumen' => 'required|string',
            'tanggal_dok' => 'required|date',
            'tanggal_terima' => 'required|date',
            'purchase_order_id' => 'required|exists:purchase_orders,idPurchaseOrder',
            'no_surat_jalan' => 'nullable|string',
            'proyek' => 'nullable|string',
            'halaman' => 'nullable|string',
            'item_ids' => 'required|array',
            'item_qty_diterima' => 'required|array',
            'item_ids.*' => 'required|integer|exists:purchase_order_items,idPurchaseOrderItem',
            'item_qty_diterima.*' => 'required|integer|min:1',
        ]);

        $receipt = new GoodsReceipts();
        $receipt->no_dokumen = $request->no_dokumen;
        $receipt->tanggal_dok = $request->tanggal_dok;
        $receipt->tanggal_terima = $request->tanggal_terima;
        $receipt->purchaseOrderId = $request->purchase_order_id;

        // Set vendor_id from purchase order
        $purchaseOrder = \App\Models\PurchaseOrder::find($request->purchase_order_id);
        $receipt->vendor_id = $purchaseOrder ? $purchaseOrder->vendorId : null;

        $receipt->no_surat_jalan = $request->no_surat_jalan;
        $receipt->proyek = $request->proyek;
        $receipt->halaman = $request->halaman;
        $saved = $receipt->save();

        Log::info('GoodsReceipts saved:', ['saved' => $saved, 'id' => $receipt->idGoodsReceipt]);

        if (!$saved) {
            return redirect()->back()->withErrors('Failed to save goods receipt.');
        }

        foreach ($request->item_ids as $index => $itemId) {
            $qty = $request->item_qty_diterima[$index] ?? 0;
            if ($qty > 0) {
                $purchaseOrderItem = \App\Models\PurchaseOrderItem::find($itemId);
                if (!$purchaseOrderItem) {
                    return redirect()->back()->withErrors('Invalid purchase order item selected.');
                }

                $item = new \App\Models\GoodsReceiptsItems();
                $item->goodsReceiptId = $receipt->idGoodsReceipt;
                $item->materialId = $purchaseOrderItem->materialId;
                $item->qty_diterima = $qty;

                // Fetch material details for deskripsi and satuan
                $material = \App\Models\Material::find($purchaseOrderItem->materialId);
                $item->deskripsi = $material->namaMaterial ?? '';
                $item->satuan = $material->satuanMaterial ?? '';
                $item->qty_po = 0; // Add default qty_po to avoid DB error
                $item->save();

                // Log after save to ensure ID is available
                Log::info('GoodsReceiptsItem saved:', ['id' => $item->idGoodReceiptsItem]);

                if (!$item->exists) {
                    return redirect()->back()->withErrors('Failed to save goods receipt item.');
                }
            }
        }

        return redirect()->route('kedatangan.index')->with('success', 'Goods receipt created.');
    }

    public function show(GoodsReceipts $goods_receipt)
    {
        return view('goods_receipts.show', compact('goods_receipt'));
    }

    public function edit(GoodsReceipts $goods_receipt)
    {
        $orders = PurchaseOrder::all();
        return view('goods_receipts.edit', compact('goods_receipt', 'orders'));
    }

    public function update(Request $request, GoodsReceipts $goods_receipt)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'receipt_date' => 'required|date',
        ]);

        $goods_receipt->update($request->only('purchase_order_id', 'receipt_date'));

        return redirect()->route('goods-receipts.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $goods_receipt = GoodsReceipts::findOrFail($id);

        // Delete related items first
        $goods_receipt->items()->delete();

        // Then delete the goods receipt
        $goods_receipt->delete();

        return redirect()->route('kedatangan.index')->with('success', 'Deleted successfully.');
    }

    public function kelolaKedatanganEdit($id)
    {
        $receipt = GoodsReceipts::with(['purchaseOrder', 'vendor', 'items'])->findOrFail($id);
        $orders = PurchaseOrder::all();

        // Prepare items with purchase order item IDs
        $itemsWithPOItemId = $receipt->items->map(function ($item) use ($receipt) {
            $poItem = \App\Models\PurchaseOrderItem::where('materialId', $item->materialId)
                ->where('purchaseOrderId', $receipt->purchaseOrderId)
                ->first();
            $item->purchaseOrderItemId = $poItem ? $poItem->idPurchaseOrderItem : null;
            return $item;
        });

        return view('kelola_kedatangan.edit', [
            'goods_receipt' => $receipt,
            'orders' => $orders,
            'itemsWithPOItemId' => $itemsWithPOItemId,
        ]);
    }

    public function kelolaKedatanganUpdate(Request $request, $id)
    {
        $request->validate([
            'no_dokumen' => 'required|string',
            'tanggal_dok' => 'required|date',
            'tanggal_terima' => 'required|date',
            'purchase_order_id' => 'required|exists:purchase_orders,idPurchaseOrder',
            'no_surat_jalan' => 'nullable|string',
            'proyek' => 'nullable|string',
            'halaman' => 'nullable|string',
            'item_ids' => 'required|array',
            'item_qty_diterima' => 'required|array',
            'item_ids.*' => 'required|integer|exists:purchase_order_items,idPurchaseOrderItem',
            'item_qty_diterima.*' => 'required|integer|min:1',
        ]);

        $receipt = GoodsReceipts::findOrFail($id);

        // Assign all fields explicitly to ensure update
        $receipt->no_dokumen = $request->no_dokumen;
        $receipt->tanggal_dok = $request->tanggal_dok;
        $receipt->tanggal_terima = $request->tanggal_terima;
        $receipt->purchaseOrderId = $request->purchase_order_id;

        $purchaseOrder = PurchaseOrder::find($request->purchase_order_id);
        $receipt->vendor_id = $purchaseOrder ? $purchaseOrder->vendorId : null;

        $receipt->no_surat_jalan = $request->no_surat_jalan;
        $receipt->proyek = $request->proyek;
        $receipt->halaman = $request->halaman;

        $saved = $receipt->save();

        if (!$saved) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Failed to update goods receipt.'], 422);
            }
            return redirect()->back()->withErrors('Failed to update goods receipt.');
        }

        // Delete existing items
        \App\Models\GoodsReceiptsItems::where('goodsReceiptId', $receipt->idGoodsReceipt)->delete();

        // Add updated items
        foreach ($request->item_ids as $index => $itemId) {
            $qty = $request->item_qty_diterima[$index] ?? 0;
            if ($qty > 0) {
                $purchaseOrderItem = \App\Models\PurchaseOrderItem::find($itemId);
                if (!$purchaseOrderItem) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['error' => 'Invalid purchase order item selected.'], 422);
                    }
                    return redirect()->back()->withErrors('Invalid purchase order item selected.');
                }

                $item = new \App\Models\GoodsReceiptsItems();
                $item->goodsReceiptId = $receipt->idGoodsReceipt;
                $item->materialId = $purchaseOrderItem->materialId;
                $item->qty_diterima = $qty;

                $material = \App\Models\Material::find($purchaseOrderItem->materialId);
                if (!$material) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['error' => 'Material not found for purchase order item.'], 422);
                    }
                    return redirect()->back()->withErrors('Material not found for purchase order item.');
                }
                $item->deskripsi = $material->namaMaterial;
                $item->satuan = $material->satuanMaterial;

                // Set qty_po from purchase order item qty_po if available, else 0
                $item->qty_po = $purchaseOrderItem->qty_po ?? 0;

                $item->save();

                if (!$item->exists) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['error' => 'Failed to save goods receipt item.'], 422);
                    }
                    return redirect()->back()->withErrors('Failed to save goods receipt item.');
                }
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => 'Goods receipt updated successfully.']);
        }

        return redirect()->route('kedatangan.index')->with('success', 'Goods receipt updated successfully.');
    }
}
