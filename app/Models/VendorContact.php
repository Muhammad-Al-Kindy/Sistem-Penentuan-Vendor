<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorContact extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'idVendorContact';

    protected $fillable = ['idVendor', 'contactPerson', 'telepon', 'fax', 'email', 'jabatan'];

    // App\Models\VendorContact.php
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}