<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'message',
        'non_conformance_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function nonConformance()
    {
        return $this->belongsTo(\App\Models\NonConformance::class, 'non_conformance_id');
    }
}
