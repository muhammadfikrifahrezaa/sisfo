<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'main_complaint',
        'anamnesa',
        'body_temperature',
        'sistole',
        'diastole',
        'nadi',
        'respiratory_frequency',
        'head_circumference',
        'height',
        'weight',
        'imt',
        'conscious',
        'notes',
        'diagnosis',
        'prognosa',
    ];

    function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    function checkup_icd10s()
    {
        return $this->hasMany(CheckupIcd10::class);
    }

    function checkup_services()
    {
        return $this->hasMany(CheckupService::class);
    }

    function checkup_medicines()
    {
        return $this->hasMany(CheckupMedicine::class);
    }
}
