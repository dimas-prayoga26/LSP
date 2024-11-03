<?php

namespace App\Http\Controllers;

use App\Models\{Event, Skema};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SkemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.skema.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_skema' => ['required', 'string', 'max:255', 'unique:m_skema,no_skema'],
            'jenis_standar' => ['required','in:KKNI,Okupasi,Klaster'],
            'kode_skema' => ['required','unique:m_skema,kode_skema'],
            'judul_skema' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required','string']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $data =  Skema::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data skema berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $skema = Skema::where('uuid', $uuid)->first();
        if($skema) {
            return response()->json(['status' => 'success', 'data' => $skema], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'no_skema' => ['required', 'string', 'max:255', 'unique:m_skema,no_skema,'. $uuid . ',uuid'],
            'jenis_standar' => ['required','in:KKNI,Okupasi,Klaster'],
            'kode_skema' => ['required','unique:m_skema,kode_skema,'. $uuid . ',uuid'],
            'judul_skema' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required','string']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = Skema::where('uuid', $uuid)->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data skema berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $skema = Skema::where('uuid', $uuid);
        if(empty($skema->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        if($skema->delete()) {
            return response()->json(['status' => 'success','message' => 'Data skema berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data skema gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = Skema::with(['event','berkasPermohonan'])
        ->latest()
        ->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Skema::with(['event','berkasPermohonan'])
        ->latest()
        ->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $eventId = Event::where('uuid', $uuid)->pluck('id');
        if(isset($eventId)) {
            $result = Skema::with(['event','berkasPermohonan'])
            ->where('event_id', $eventId)
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data event tidak ditemukan'], 404);
        }
    }
}
