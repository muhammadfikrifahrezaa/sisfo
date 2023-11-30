<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Poli;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class RegistrationController extends Controller
{
    function index()
    {
        $polis = Poli::pluck('name', 'id');
        $doctors = User::where('role', 'Dokter')->pluck('name', 'id');
        return view('registration.index', compact('polis', 'doctors'));
    }

    function create()
    {
        if (request()->ajax()) {
            $query = Registration::with('patient', 'user', 'poli', 'doctor_schedule');
            $query->when(request('consultation_date'), function ($query) {
                $query->whereDate('consultation_date', request('consultation_date'));
            });
            $query->when(request('poli_id'), function ($query) {
                $query->where('registrations.poli_id', request('poli_id'));
            });
            $query->when(request('user_id'), function ($query) {
                $query->where('registrations.user_id', request('user_id'));
            });
            $query->when(request('status'), function ($query) {
                $query->where('registrations.status', request('status'));
            });
            $query->when(request('search'), function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('registrations.queue_number', 'like', "%" . request('search') . "%");
                    $q->orWhere('name', 'like', "%" . request('search') . "%");
                    $q->orWhere('registration_number', 'like', "%" . request('search') . "%");
                });
            });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $button = '<div class="btn-group pull-right">';
                    if ($row->status == 'Dalam Antrian' || $row->status == 'Pemeriksaan') {
                        $button .= '<a class="btn btn-sm btn-primary" href=' . route('checkup.create', ['registrationId' => $row->id]) . '><i class="fa fa-file-text"></i></a>';
                        $button .= '<button class="btn btn-sm btn-danger" id="cancel" data-integrity="' . $row->id . '"><i class="fa fa-times"></i></button>';
                    }
                    $button .= '</div>';
                    return $button;
                })
                ->editColumn('consultation_date', function ($row) {
                    return ' ' . date('d F Y', strtotime($row->consultation_date)) . '<br>
                                <small>' . date('H:i', strtotime($row->doctor_schedule->start_time)) . ' - ' . date('H:i', strtotime($row->doctor_schedule->end_time)) . '</small>
                            ';
                })
                ->editColumn('patient_id', function ($row) {
                    return '<b>' . $row->patient->name . '</b><br>
                    <small>' . $row->patient->registration_number . '</small>';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Dalam Antrian') {
                        return '<span class="label label-warning">' . $row->status . '</span>';
                    } else if ($row->status == 'Pemeriksaan') {
                        return '<span class="label label-success">' . $row->status . '</span>';
                    } else if ($row->status == 'Selesai') {
                        return '<span class="label label-primary">' . $row->status . '</span>';
                    } else {
                        return '<span class="label label-danger">' . $row->status . '</span>';
                    }
                })
                ->rawColumns(['action', 'consultation_date', 'patient_id', 'status'])
                ->toJson();
        }
        $polis = Poli::pluck('name', 'id');
        return view('registration.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $poli = Poli::find($request->poli_id);
        $registration = Registration::query()
            ->where('poli_id', $request->poli_id)
            ->whereDate('consultation_date', $request->consultation_date)
            ->latest()
            ->first();
        $queue_number = $registration ? sprintf($poli->code . '%05s', substr($registration->queue_number, strlen($poli->code)) + 1) : $poli->code . '00001';
        try {
            $data = $request->all();
            $data['queue_number'] = $queue_number;

            Registration::create($data);
            return redirect()->route('registration.index');
        } catch (\Exception $e) {
            return redirect()->route('registration.index');
        }
    }

    function searchPatient(Request $request)
    {
        $search = $request->searchTerm;
        $patient = Patient::query()
            ->orderBy('name', 'asc')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%" . $search . "%");
            })
            ->get();


        return response()->json([
            'res' => 'success',
            'data' => $patient
        ]);
    }

    function selectPatient($patientId)
    {
        $patient = Patient::find($patientId);
        return response()->json([
            'res' => 'success',
            'data' => $patient
        ]);
    }

    function getDoctorByPoli($poliId, $date)
    {
        $day = date('l', strtotime($date));
        $day_en_to_id = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $doctor = DoctorSchedule::select('user_id')
            ->with('user')
            ->where('poli_id', $poliId)
            ->where('day', $day_en_to_id[$day])
            ->distinct()
            ->get();

        return response()->json([
            'res' => 'success',
            'data' => $doctor
        ]);
    }

    function getDoctorSchedule($poliId, $date, $userId)
    {
        $day = date('l', strtotime($date));
        $day_en_to_id = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $schedule = DoctorSchedule::query()
            ->where('poli_id', $poliId)
            ->where('user_id', $userId)
            ->where('day', $day_en_to_id[$day])
            ->get();

        return response()->json([
            'res' => 'success',
            'data' => $schedule
        ]);
    }

    function destroy($registrationId)
    {
        try {
            Registration::findOrFail($registrationId)->update([
                'status' => 'Dibatalkan'
            ]);
            return response()->json(['res' => 'success'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
