<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorEvaluaations extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $primaryKey = 'idVendorEvaluation';

    protected $fillable = ['vendorId', 'material_id', 'purchase_order_id', 'delivery_score', 'monitoring_score', 'quality_score', 'respon_nc_score', 'po_batal_score', 'tanggal_evaluasi'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function purchase()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}