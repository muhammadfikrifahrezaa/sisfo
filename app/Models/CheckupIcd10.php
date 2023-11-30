<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupIcd10 extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'icd10_id'
    ];


    function icd10()
    {
        return $this->belongsTo(ICD10::class);
    }
}
