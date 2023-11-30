<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_number',
        'patient_id',
        'poli_id',
        'user_id',
        'doctor_schedule_id',
        'type_visit',
        'type_treatment',
        'consultation_date',
        'financing',
        'status'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    function doctor_schedule()
    {
        return $this->belongsTo(DoctorSchedule::class);
    }

    function checkup()
    {
        return $this->hasOne(Checkup::class);
    }
}
