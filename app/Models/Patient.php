<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'phone_number',
        'date_of_birth',
        'gender',
        'type_identity',
        'no_identity',
        'blood_type',
        'address'
    ];

    function allergies()
    {
        return $this->hasMany(PatientAllergy::class);
    }

    function diseases_histories()
    {
        return $this->hasMany(PatientDiseaseHistory::class);
    }
}
