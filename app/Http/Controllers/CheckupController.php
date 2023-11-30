<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\CheckupIcd10;
use App\Models\CheckupMedicine;
use App\Models\CheckupService;
use App\Models\ICD10;
use App\Models\Medicine;
use App\Models\PatientAllergy;
use App\Models\PatientDiseaseHistory;
use App\Models\Poli;
use App\Models\Registration;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CheckupController extends Controller
{
    function index()
    {
        $polis = Poli::pluck('name', 'id');
        $doctors = User::where('role', 'Dokter')->pluck('name', 'id');
        return view('medical-record.index', compact('polis', 'doctors'));
    }


    function create(Request $request)
    {
        if (request()->ajax()) {
            $query = Checkup::with('registration');
            $query->when(request('created_at'), function ($query) {
                $query->whereDate('created_at', request('created_at'));
            });
            $query->when(request('poli_id'), function ($query) {
                $query->whereHas('registration', function ($q1) {
                    $q1->whereHas('poli', function ($q) {
                        $q->where('registrations.poli_id', request('poli_id'));
                    });
                });
            });
            $query->when(request('user_id'), function ($query) {
                $query->whereHas('registration', function ($q1) {
                    $q1->whereHas('user', function ($q) {
                        $q->where('registrations.user_id', request('user_id'));
                    });
                });
            });
            $query->when(request('search'), function ($query) {
                $query->whereHas('registration', function ($q1) {
                    $q1->whereHas('patient', function ($q) {
                        $q->Where('name', 'like', "%" . request('search') . "%");
                        $q->orWhere('registration_number', 'like', "%" . request('search') . "%");
                    });
                });
            });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $button = '<div class="btn-group pull-right">';
                    $button .= '<a class="btn btn-sm btn-info" href="' . route('checkup.show', $row->id) . '"><i class="fa fa-search"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->editColumn('created_at', function ($row) {
                    return ' ' . date('d F Y', strtotime($row->created_at)) . ' <br>
                    <small>' . date('H:i', strtotime($row->registration->doctor_schedule->start_time)) . ' - ' . date('H:i', strtotime($row->registration->doctor_schedule->end_time)) . '</small>';
                })
                ->addColumn('patient', function ($row) {
                    return '<b>' . $row->registration->patient->name . '</b><br>
                    <small>' . $row->registration->patient->registration_number . '</small>';
                })
                ->addColumn('doctor', function ($row) {
                    return ' ' . $row->registration->user->name . ' <br>
                    <small>' . $row->registration->poli->name . '</small>';
                })
                ->rawColumns(['action', 'created_at', 'patient', 'doctor'])
                ->toJson();
        }
        Registration::find($request->registrationId)
            ->update(['status' => 'Pemeriksaan']);

        $registration = Registration::query()
            ->find($request->registrationId)
            ->load('user', 'poli', 'patient', 'doctor_schedule');

        $checkup_histories = Registration::with('checkup')
            ->where('patient_id', $registration->patient_id)
            ->whereHas('checkup', function ($q) {
                $q->orderBy('created_at', 'desc');
            })
            ->take(10)
            ->get();

        $services = Service::where('poli_id', $registration->poli_id)->pluck('name', 'id');
        return view('medical-record.create', compact('registration', 'services', 'checkup_histories'));
    }

    function createPatientDisease(Request $request)
    {
        $disease = PatientDiseaseHistory::create($request->all());
        return response()->json([
            'res' => 'success',
            'data' => $disease
        ], Response::HTTP_CREATED);
    }

    function destroyPatientDisease($diseaseId)
    {
        PatientDiseaseHistory::find($diseaseId)->delete();
        return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
    }

    function createPatientAllergy(Request $request)
    {
        $allergy = PatientAllergy::create($request->all());
        return response()->json([
            'res' => 'success',
            'data' => $allergy
        ], Response::HTTP_CREATED);
    }

    function destroyPatientAllergy($allergyId)
    {
        PatientAllergy::find($allergyId)->delete();
        return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
    }

    function getICD10()
    {
        $icd10 = ICD10::query();
        return DataTables::of($icd10)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<div class="btn-group pull-right">';
                $button .= '<button class="btn btn-sm btn-primary" type="button" data-id="' . $row->id . '" id="selectICD10"><i class="fa fa-arrow-right"></i></button>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    function searchMedicine(Request $request)
    {
        $search = $request->searchTerm;
        $medicines = Medicine::query()
            ->orderBy('name', 'asc')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%" . $search . "%");
                $q->orWhere('code', 'like', "%" . $search . "%");
            })
            ->get();

        return response()->json([
            'res' => 'success',
            'data' => $medicines
        ]);
    }

    function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            Registration::find($request->registration_id)
                ->update(['status' => 'Selesai']);

            $checkup = Checkup::create([
                'registration_id' => $request->registration_id,
                'main_complaint' => $request->main_complaint,
                'anamnesa' => $request->anamnesa,
                'body_temperature' => $request->body_temperature,
                'sistole' => $request->sistole,
                'diastole' => $request->diastole,
                'nadi' => $request->nadi,
                'respiratory_frequency' => $request->respiratory_frequency,
                'height' => $request->height,
                'weight' => $request->weight,
                'head_circumference' => $request->head_circumference,
                'abdominal_circumference' => $request->abdominal_circumference,
                'imt' => $request->imt,
                'notes' => $request->notes,
                'conscious' => $request->conscious,
                'diagnosis' => $request->diagnosis,
                'prognosa' => $request->prognosa,
            ]);

            if (isset($request->icd10_id)) {
                $checkup_icd10s = [];
                foreach ($request->icd10_id as $key => $value) {
                    $checkup_icd10s[$key] = [
                        'checkup_id' => $checkup->id,
                        'icd10_id' => $request->icd10_id[$key],
                        'created_at' => now()
                    ];
                }
                CheckupIcd10::insert($checkup_icd10s);
            }

            if (isset($request->service_id)) {
                $checkup_services = [];
                foreach ($request->service_id as $key => $value) {
                    $checkup_services[$key] = [
                        'checkup_id' => $checkup->id,
                        'service_id' => $request->service_id[$key],
                        'qty' => $request->service_qty[$key],
                        'created_at' => now()
                    ];
                }
                CheckupService::insert($checkup_services);
            }

            if (isset($request->medicine_id)) {
                $checkup_medicines = [];
                foreach ($request->medicine_id as $key => $value) {
                    $checkup_medicines[$key] = [
                        'checkup_id' => $checkup->id,
                        'medicine_id' => $request->medicine_id[$key],
                        'dosis' => $request->medicine_dosis[$key],
                        'duration' => $request->medicine_duration[$key],
                        'unit' => $request->medicine_unit[$key],
                        'qty' => $request->medicine_qty[$key],
                        'notes' => $request->medicine_notes[$key],
                        'created_at' => now()
                    ];
                }
                CheckupMedicine::insert($checkup_medicines);
            }
        });

        return redirect()->route('checkup.index');
    }

    function show($checkupId)
    {
        $checkup = Checkup::find($checkupId)->load('registration');
        return view('medical-record.detail', compact('checkup'));
    }
}
