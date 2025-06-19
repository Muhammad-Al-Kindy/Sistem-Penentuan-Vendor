<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorEvaluaations extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $primaryKey = 'idMaterial';

    protected $fillable = ['vendorId', 'kriteriaId', 'nilai', 'periode'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}