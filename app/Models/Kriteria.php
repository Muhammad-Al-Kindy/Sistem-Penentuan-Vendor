<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $primaryKey = 'idKriteria';

    public $timestamps = false;

    protected $fillable = ['namaKriteria', 'tipe'];

    public function subKriteria()
    {
        return $this->hasMany(subKriteria::class, 'idKriteria', 'kriteriaId');
    }
}