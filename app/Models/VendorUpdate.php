<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorUpdate extends Model
{
    use HasFactory;

    protected $primaryKey = 'vendor_update_id';

    protected $fillable = [
        'purchase_order_id',
        'vendor_id',
        'tanggal_update',
        'jenis_update',
        'dokumen',
        'keterangan',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'idPurchaseOrder');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'idVendor');
    }
}