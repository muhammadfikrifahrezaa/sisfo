<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDiseaseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'disease_name'
    ];
}
