<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipts extends Model
{
    use HasFactory;

    protected $primaryKey = 'idGoodsReceipt';

    protected $fillable = ['no_dokumen', 'tanggal_dok', 'tanggal_terima', 'purchaseOrderId', 'vendor_id', 'no_surat_jalan', 'proyek', 'halaman'];


    public $timestamps = true;

    // GoodsReceipt.php
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchaseOrderId', 'idPurchaseOrder');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'idVendor');
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptsItems::class, 'goodsReceiptId', 'idGoodsReceipt');
    }
}