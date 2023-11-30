<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

use Yajra\DataTables\QueryDataTable;
use App\Models\Poli;

class PoliController extends Controller
{
    public function index(): View
    {
        return view('master-data.poli.index');
    }

    public function create(): JsonResponse
    {
        $query = DB::table('polis');
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
            Poli::create($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        return Poli::findOrFail($id);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            Poli::findOrFail($id)->update($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            Poli::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
