<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TestWawancara,KriteriaUnjukKerja,UnitKompetensi};
use Illuminate\Support\Facades\Validator;

class TestWawancaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.testWawancara.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_kompetensi_id' => ['required', 'exists:m_unit_kompetensi,uuid'],
            'kriteria_unjuk_kerja_id' => ['required', 'exists:m_kriteria_unjuk_kerja,uuid'],
            'pertanyaan' => ['required']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $unitKompetensi = UnitKompetensi::firstWhere('uuid', $validated['unit_kompetensi_id']);
        $kuk = KriteriaUnjukKerja::firstWhere('uuid', $validated['kriteria_unjuk_kerja_id']);

        if(empty($unitKompetensi)) {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }
        if(empty($kuk)) {
            return response()->json(['status' => 'error', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }
        $validated['unit_kompetensi_id'] = $unitKompetensi['id'];
        $validated['kriteria_unjuk_kerja_id'] = $kuk['id'];

        $data = TestWawancara::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data test wawancara berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $testWawancara = TestWawancara::with(['unitKompetensi','kriteriaUnjukKerja'])
            ->firstWhere('uuid', $uuid);
        if(!empty($testWawancara)) {
            return response()->json(['status' => 'success', 'data' => $testWawancara], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data test tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'unit_kompetensi_id' => ['required', 'exists:m_unit_kompetensi,uuid'],
            'kriteria_unjuk_kerja_id' => ['required', 'exists:m_kriteria_unjuk_kerja,uuid'],
            'pertanyaan' => ['required']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = TestWawancara::firstWhere('uuid', $uuid);
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data test tidak ditemukan'], 404);
        }

        $unitKompetensi = UnitKompetensi::firstWhere('uuid', $validated['unit_kompetensi_id']);
        $kuk = KriteriaUnjukKerja::firstWhere('uuid', $validated['kriteria_unjuk_kerja_id']);

        if(empty($unitKompetensi)) {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }
        if(empty($kuk)) {
            return response()->json(['status' => 'error', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }

        $validated['unit_kompetensi_id'] = $unitKompetensi['id'];
        $validated['kriteria_unjuk_kerja_id'] = $kuk['id'];

        $result = $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data test berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $testWawancara = TestWawancara::firstWhere('uuid', $uuid);
        if(empty($testWawancara)) {
            return response()->json(['status' => 'error', 'message' => 'Data test tidak ditemukan'], 404);
        }
        if($testWawancara->delete()) {
            return response()->json(['status' => 'success','message' => 'Data test berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data test gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = TestWawancara::with(['unitKompetensi','kriteriaUnjukKerja'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = TestWawancara::with(['unitKompetensi','kriteriaUnjukKerja'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
