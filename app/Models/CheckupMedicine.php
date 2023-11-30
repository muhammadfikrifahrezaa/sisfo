<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'medicine_id'
    ];

    function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
