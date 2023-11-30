<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'poli_id',
    ];

    function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
