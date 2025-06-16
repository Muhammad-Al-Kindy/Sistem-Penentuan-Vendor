<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVendorPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'idMaterialVendorPrice';

    protected $fillable = ['materialId', 'vendorId', 'harga', 'mataUang'];
}
