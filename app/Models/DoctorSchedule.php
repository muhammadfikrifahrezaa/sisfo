<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'poli_id',
        'user_id',
        'day',
        'start_time',
        'end_time'
    ];

    function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
