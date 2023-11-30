<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

use Yajra\DataTables\QueryDataTable;
use App\Models\ICD10;

class ICD10Controller extends Controller
{
    public function index(): View
    {
        return view('master-data.icd10.index');
    }

    public function create(): JsonResponse
    {
        $query = DB::table('icd10s');
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
            ICD10::create($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        return ICD10::findOrFail($id);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            ICD10::findOrFail($id)->update($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            ICD10::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
