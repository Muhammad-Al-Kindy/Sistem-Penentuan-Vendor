<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfqs extends Model
{
    use HasFactory;

    protected $primaryKey = 'idrfqs';

    protected $fillable = [
        'purchaseOrderId',
        'no_rfq',
        'rfq_collective',
        'referensi_sph',
        'no_justifikasi',
        'no_negosiasi',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchaseOrderId', 'idPurchaseOrder');
    }
}