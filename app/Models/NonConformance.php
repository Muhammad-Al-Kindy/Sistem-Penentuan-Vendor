<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonConformance extends Model
{
    use HasFactory;

    protected $primaryKey = 'idNonConformance';

    protected $fillable = [
        'goods_receipt_item_id',
        'tanggal_ditemukan',
        'tanggal_respon_vendor',
        'status',
        'keterangan',
    ];

    public function goodsReceiptItem()
    {
        return $this->belongsTo(GoodsReceiptsItems::class, 'goods_receipt_item_id', 'idGoodReceiptsItem');
    }


    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'non_conformance_id', 'idNonConformance');
    }
}