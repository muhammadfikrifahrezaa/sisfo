<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class DoctorScheduleController extends Controller
{
    function index()
    {
        return view('doctor-schedule.index');
    }

    function create()
    {
        $doctor = User::where('role', 'Dokter');
        return DataTables::of($doctor)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<div class="btn-group pull-right">';
                $button .= '<a class="btn btn-sm btn-info" href=' . route('doctor-schedule.show', $row->id) . '><i class="fa fa-calendar"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    function data($userId)
    {
        $schedule = DoctorSchedule::where('user_id', $userId)->with(['poli']);
        return DataTables::of($schedule)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $this->_getActionButton($row->id);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    function show($id)
    {
        if (request()->ajax()) {
            return DoctorSchedule::find($id)->poli_id;
        }
        $user = User::find($id)->load('schedules');
        $polis = Poli::pluck('name', 'id');
        return view('doctor-schedule.detail', compact('user', 'polis'));
    }


    function store(Request $request)
    {
        DoctorSchedule::create($request->all());
        return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
    }

    function update($scheduleId, Request $request)
    {
        DoctorSchedule::find($scheduleId)->update($request->all());
        return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
    }

    function destroy($scheduleId)
    {
        DoctorSchedule::find($scheduleId)->delete();
        return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
    }
}
