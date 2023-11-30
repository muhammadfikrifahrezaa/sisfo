<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

use Yajra\DataTables\QueryDataTable;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(): View
    {
        return view('patient.index');
    }

    public function create()
    {
        if (request()->ajax()) {
            $query = DB::table('patients');
            return (new QueryDataTable($query))
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $button = '<div class="btn-group pull-right">';
                    $button .= '<a class="btn btn-sm btn-warning" href=' . route('patient.show', $row->id) . '><i class="fa fa-edit"></i></a>';
                    $button .= '<button class="btn btn-sm btn-danger" id="delete" data-integrity="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        $last_patient = Patient::latest()->first();
        $registration_number = $last_patient ? sprintf('MDFJ%06s', substr($last_patient->registration_number, 4) + 1) : 'MDFJ000001';
        return view('patient.create', compact('registration_number'));
    }

    public function store(Request $request)
    {
        try {
            Patient::create($request->all());
            return redirect()->route('patient.index');
        } catch (\Exception $e) {
            return redirect()->route('patient.index');
        }
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.update', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        try {
            Patient::find($id)->update($request->all());
            return redirect()->route('patient.index');
        } catch (\Exception $e) {
            return redirect()->route('patient.index');
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            Patient::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
