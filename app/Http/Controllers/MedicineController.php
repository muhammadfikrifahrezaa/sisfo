<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

use Yajra\DataTables\QueryDataTable;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index(): View
    {
        $last_medicine = Medicine::latest()->first();
        $medicine_code = $last_medicine ? sprintf('OB%05s', substr($last_medicine->code, 2) + 1) : 'OB00001';
        return view('master-data.medicine.index', compact('medicine_code'));
    }

    public function create(): JsonResponse
    {
        $query = DB::table('medicines');
        return (new QueryDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return parent::_getActionButton($row->id);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request): JsonResponse
    {
        try {
            Medicine::create($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        return Medicine::findOrFail($id);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            Medicine::findOrFail($id)->update($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            Medicine::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
