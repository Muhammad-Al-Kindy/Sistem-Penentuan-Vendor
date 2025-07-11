<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptsItems extends Model
{
    use HasFactory;

    protected $primaryKey = 'idGoodReceiptsItem';

    protected $fillable = ['goodsReceiptId', 'materialId', 'deskripsi', 'satuan', 'qty_po', 'qty_diterima', 'ncr', 'lokasi_gudang'];


    public $timestamps = true;

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipts::class);
    }

    public function items()
    {
        return $this->belongsTo(Material::class);
    }
}