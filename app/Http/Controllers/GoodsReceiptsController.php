<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipts;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class GoodsReceiptsController extends Controller
{
    public function index()
    {
        $receipts = GoodsReceipts::with('purchaseOrder')->paginate(10);
        return view('goods_receipts.index', compact('receipts'));
    }

    public function create()
    {
        $orders = PurchaseOrder::all();
        return view('goods_receipts.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'receipt_date' => 'required|date',
        ]);

        $receipt = GoodsReceipts::create($request->only('purchase_order_id', 'receipt_date'));

        return redirect()->route('goods-receipts.index')->with('success', 'Goods receipt created.');
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

    public function destroy(GoodsReceipts $goods_receipt)
    {
        $goods_receipt->delete();
        return redirect()->route('goods-receipts.index')->with('success', 'Deleted successfully.');
    }
}