<?php

namespace App\Http\Controllers;

use App\Models\{BerkasPemohon,Skema};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BerkasPemohonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.berkasPemohon.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_berkas' => ['required', 'string', 'max:255'],
            'skema_id' => ['required','exists:m_skema,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $skema = Skema::where('uuid', $validated['skema_id'])->first();
        if(empty($skema)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        $validated['skema_id'] = (int) $skema['id'];

        $data =  BerkasPemohon::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data berkas pemohon berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $berkasPemohon = BerkasPemohon::with('skema')
            ->where('uuid', $uuid)
            ->first();
        if($berkasPemohon) {
            return response()->json(['status' => 'success', 'data' => $berkasPemohon], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data berkas pemohon tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama_berkas' => ['required', 'string', 'max:255'],
            'skema_id' => ['required','exists:m_skema,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = BerkasPemohon::where('uuid', $uuid)->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data berkas pemohon tidak ditemukan'], 404);
        }

        $skema = Skema::where('uuid', $validated['skema_id'])->first();
        if(empty($skema)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        $validated['skema_id'] = (int) $skema['id'];

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berkas pemohon berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $berkasPemohon = BerkasPemohon::where('uuid', $uuid);
        if(empty($berkasPemohon->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data berkas pemohon tidak ditemukan'], 404);
        }
        if($berkasPemohon->delete()) {
            return response()->json(['status' => 'success','message' => 'Data berkas pemohon berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data berkas pemohon gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = BerkasPemohon::with('skema')
            ->latest()
            ->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = BerkasPemohon::with('skema')
            ->latest()
            ->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $skemaiId = Skema::with(['event','berkasPermohonan'])
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($skemaiId)) {
            $result = BerkasPemohon::with('skema')
                ->where('skema_id', $skemaiId)
                ->latest()
                ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data skema tidak ditemukan'], 404);
        }
    }
}
