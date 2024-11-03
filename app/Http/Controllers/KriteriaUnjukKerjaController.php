<?php

namespace App\Http\Controllers;

use App\Models\{KriteriaUnjukKerja,Elemen, UnitKompetensi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class KriteriaUnjukKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.kriteriaUnjukKerja.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kriteria_kerja' => ['required', 'string', 'max:255'],
            'elemen_id' => ['required', 'exists:m_elemen,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $elemen = Elemen::where('uuid', $validated['elemen_id'])->first();
        if(empty($elemen)) {
            return response()->json(['status' => 'error', 'message' => 'Data elemen tidak ditemukan'], 404);
        }
        $validated['elemen_id'] = (int) $elemen['id'];
        $data =  KriteriaUnjukKerja::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data kriteria unjuk kerja berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $kriteriaUnjukKerja = KriteriaUnjukKerja::with(['testTulis','elemen'])
            ->where('uuid', $uuid)
            ->first();
        if(!empty($kriteriaUnjukKerja)) {
            return response()->json(['status' => 'success', 'data' => $kriteriaUnjukKerja], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama_kriteria_kerja' => ['required', 'string', 'max:255'],
            'elemen_id' => ['required', 'exists:m_elemen,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = KriteriaUnjukKerja::where('uuid', $uuid)
            ->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }

        $elemen = Elemen::where('uuid', $validated['elemen_id'])->first();
        if(empty($elemen)) {
            return response()->json(['status' => 'error', 'message' => 'Data elemen tidak ditemukan'], 404);
        }
        $validated['elemen_id'] = (int) $elemen['id'];

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data kriteria unjuk kerja berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $kriteriaUnjukKerja = KriteriaUnjukKerja::where('uuid', $uuid);
        if(empty($kriteriaUnjukKerja->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }
        if($kriteriaUnjukKerja->delete()) {
            return response()->json(['status' => 'success','message' => 'Data kriteria unjuk kerja berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data kriteria unjuk kerja gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = KriteriaUnjukKerja::with(['testTulis','elemen'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = KriteriaUnjukKerja::with(['testTulis','elemen'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $elemenId = Elemen::where('uuid',$uuid)
            ->pluck('id');
        if(isset($elemenId)) {
            $result = KriteriaUnjukKerja::with(['testTulis','elemen'])
            ->where('elemen_id', $elemenId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data elemen tidak ditemukan'], 404);
        }
    }

    public function listByUnitKompetensi($uuid)
    {
        $unitKomptensiId = UnitKompetensi::where('uuid', $uuid)->pluck('id');
        if(empty($unitKomptensiId)) {
            return response()->json(['status' => 'success', 'message' => 'Data unit kompetensi tidak ditemukan'], 500);
        }
        $elemen = Elemen::with('kriteriaUnjukKerja')->firstWhere('unit_kompetensi_id', $unitKomptensiId);
        $unjukKerja = !empty($elemen->kriteriaUnjukKerja) ? $elemen->kriteriaUnjukKerja : [];

        return response()->json(['status' => 'success', 'data' => $unjukKerja, 'totalRecord' => count($unjukKerja)], 200);
    }
}
