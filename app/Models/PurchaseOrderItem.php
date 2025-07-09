<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPurchaseOrderItem';

    protected $fillable = ['purchaseOrderId', 'materialId', 'materialVendorPriceId', 'kuantitas', 'hargaPerUnit', 'mataUang', 'vat', 'batasDiterima', 'total'];

    protected $casts = [
        'batasDiterima' => 'date',
    ];

    public $timestamps = true;

    // PurchaseOrderItem.php
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchaseOrderId', 'idPurchaseOrder');
    }

    public function item()
    {
        return $this->belongsTo(Material::class, 'materialId', 'idMaterial');
    }

    public function vendorPrice()
    {
        return $this->belongsTo(MaterialVendorPrice::class);
    }
}
