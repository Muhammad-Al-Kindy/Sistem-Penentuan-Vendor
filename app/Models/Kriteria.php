<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $primaryKey = 'idKriteria';

    public $timestamps = false;

    protected $fillable =['namaKriteria','bobot'];

    public function subKriteria()
    {
        return $this->hasOne(subKriteria::class,'idKriteria','kriteriaId');
    }
}