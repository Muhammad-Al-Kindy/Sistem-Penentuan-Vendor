<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable =['kriteriaId','namaSubKriteria','skorSubKriteria'];

    public function kriteria()
    {
        return $this->belongsTo(kriteria::class,'kriteriaId','idKriteria');
    }
}