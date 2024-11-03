<?php

namespace App\Http\Controllers;

use App\Models\{Asesor, Event, Kelas, KelompokAsesor,Skema};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelompokAsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.assignKelompokAsesor.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => ['required', 'exists:m_event,uuid'],
            'skema_id' => ['required', 'exists:m_skema,uuid'],
            'kelas_id' => ['required', 'exists:m_kelas,uuid'],
            'asesor_id' => ['required', 'exists:m_asesor,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $event = Event::firstWhere('uuid', $validated['event_id']);
        $skema = Skema::firstWhere('uuid', $validated['skema_id']);
        $kelas = Kelas::firstWhere('uuid', $validated['kelas_id']);
        $asesor = Asesor::firstWhere('uuid', $validated['asesor_id']);

        if(empty($event)) {
            return response()->json(['status' => 'error', 'message' => 'Data event tidak ditemukan'], 404);
        }
        if(empty($skema)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        if(empty($kelas)) {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
        }
        if(empty($asesor)) {
            return response()->json(['status' => 'error', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
        $validated['event_id'] = (int) $event['id'];
        $validated['skema_id'] = (int) $skema['id'];
        $validated['kelas_id'] = (int) $kelas['id'];
        $validated['asesor_id'] = (int) $asesor['id'];

        $data =  KelompokAsesor::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data kelompok asesor berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $kelompokAsesor = KelompokAsesor::with(['event','skema','kelas','asesor.user'])
        ->firstWhere('uuid', $uuid);

        if(!empty($kelompokAsesor)) {
            return response()->json(['status' => 'success', 'data' => $kelompokAsesor], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => ['required', 'exists:m_event,uuid'],
            'skema_id' => ['required', 'exists:m_skema,uuid'],
            'kelas_id' => ['required', 'exists:m_kelas,uuid'],
            'asesor_id' => ['required', 'exists:m_asesor,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = KelompokAsesor::firstWhere('uuid', $uuid);
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        $event = Event::firstWhere('uuid', $validated['event_id']);
        $skema = Skema::firstWhere('uuid', $validated['skema_id']);
        $kelas = Kelas::firstWhere('uuid', $validated['kelas_id']);
        $asesor = Asesor::firstWhere('uuid', $validated['asesor_id']);

        if(empty($event)) {
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }
        if(empty($skema)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        if(empty($kelas)) {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
        }
        if(empty($asesor)) {
            return response()->json(['status' => 'error', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
        $validated['event_id'] = (int) $event['id'];
        $validated['skema_id'] = (int) $skema['id'];
        $validated['kelas_id'] = (int) $kelas['id'];
        $validated['asesor_id'] = (int) $asesor['id'];

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data kelompok asesor berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $kelompokAsesor = KelompokAsesor::where('uuid', $uuid);
        if(empty($kelompokAsesor->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }
        if($kelompokAsesor->delete()) {
            return response()->json(['status' => 'success','message' => 'Data kelompok asesor berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = KelompokAsesor::with(['event','skema','kelas','asesor.user'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = KelompokAsesor::with(['event','skema','kelas','asesor.user'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
