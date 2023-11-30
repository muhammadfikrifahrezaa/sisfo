<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupService extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'service_id'
    ];

    function service()
    {
        return $this->belongsTo(Service::class);
    }
}
