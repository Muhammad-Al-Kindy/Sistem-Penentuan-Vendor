<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPurchaseOrder';

    protected $fillable = ['vendorId', 'noPO', 'tanggalPO', 'noKontrak', 'noRevisi', 'tanggalRevisi', 'incoterm', 'created_by'];

    protected $casts = [
        'tanggalPO' => 'date',
        'tanggalRevisi' => 'date',
    ];

    public $timestamps = true;

    // PurchaseOrder.php
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchaseOrderId', 'idPurchaseOrder');
    }

    public function rfq()
    {
        return $this->hasOne(Rfqs::class, 'purchaseOrderId', 'idPurchaseOrder');
    }

    public function receipts()
    {
        return $this->hasMany(GoodsReceipts::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendorId', 'idVendor');
    }

    public function vendorUpdates()
    {
        return $this->hasMany(VendorUpdate::class, 'purchase_order_id', 'idPurchaseOrder');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
