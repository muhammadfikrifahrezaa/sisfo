<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $patient_today = Registration::whereDate('consultation_date', date('Y-m-d'))->count();
        $patient_in_queue = Registration::whereDate('consultation_date', date('Y-m-d'))
            ->where('status', 'Dalam Antrian')
            ->count();
        $patient_done = Registration::whereDate('consultation_date', date('Y-m-d'))
            ->where('status', 'Selesai')
            ->count();
        $patient_canceled = Registration::whereDate('consultation_date', date('Y-m-d'))
            ->where('status', 'Dibatalkan')
            ->count();

        return view('dashboard', compact('patient_today', 'patient_in_queue', 'patient_done', 'patient_canceled'));
    }
}
