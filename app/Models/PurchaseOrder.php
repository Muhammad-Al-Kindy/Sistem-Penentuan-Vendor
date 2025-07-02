<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPurchaseOrder';

    protected $fillable = ['vendorId', 'noPO', 'tanggalPO', 'noKontrak', 'noRevisi', 'tanggalRevisi', 'incoterm', 'created_by'];


    public $timestamps = true;

    // PurchaseOrder.php
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function rfq()
    {
        return $this->hasOne(Rfqs::class);
    }

    public function receipts()
    {
        return $this->hasMany(GoodsReceipts::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendorId', 'idVendor');
    }
}
