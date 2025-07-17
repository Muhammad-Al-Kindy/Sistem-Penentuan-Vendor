<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'idVendor';

    protected $fillable = ['namaVendor', 'alamatVendor', 'NPWP', 'jenisPerusahaan', 'SPPKP', 'nomorIndukPerusahaan', 'user_id'];


    public function getRouteKeyName()
    {
        return 'idVendor';
    }

    // App\Models\Vendor.php
    public function contacts()
    {
        return $this->hasMany(VendorContact::class, 'vendorId', 'idVendor');
    }

    public function evaluations()
    {
        return $this->hasMany(VendorEvaluaations::class, 'vendorId', 'idVendor');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'idUser');
    }

    public function vendorUpdates()
    {
        return $this->hasMany(VendorUpdate::class, 'vendor_id', 'idVendor');
    }
}
