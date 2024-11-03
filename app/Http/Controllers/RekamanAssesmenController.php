<?php

namespace App\Http\Controllers;

use App\Models\RekamanAssesmen;
use App\Http\Requests\StoreRekamanAssesmenRequest;
use App\Http\Requests\UpdateRekamanAssesmenRequest;
use App\Models\Asesor;

class RekamanAssesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRekamanAssesmenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RekamanAssesmen $rekamanAssesmen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekamanAssesmen $rekamanAssesmen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRekamanAssesmenRequest $request, RekamanAssesmen $rekamanAssesmen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamanAssesmen $rekamanAssesmen)
    {
        //
    }

    public function datatable()
    {
        $data = RekamanAssesmen::with(['asesor','asesi','skema'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = RekamanAssesmen::with(['asesor','asesi','skema'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $asesorId = Asesor::with('user')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($asesorId)) {
            $result = RekamanAssesmen::with(['asesor','asesi','skema'])
            ->where('asesor_id', $asesorId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
    }
}
