<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'idMaterial';

    protected $fillable = ['kodeMaterial', 'namaMaterial', 'deskripsiMaterial', 'satuanMaterial'];

    // Item.php
    public function vendorPrices()
    {
        return $this->hasMany(MaterialVendorPrice::class);
    }

    public function poItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function goodsReceiptItems()
    {
        return $this->hasMany(GoodsReceiptsItems::class);
    }
}