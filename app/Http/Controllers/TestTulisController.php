<?php

namespace App\Http\Controllers;

use App\Models\TestTulis;
use Illuminate\Http\Request;
use App\Models\KriteriaUnjukKerja;
use App\Models\UnitKompetensi;
use Illuminate\Support\Facades\Validator;

class TestTulisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.testTulis.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_kompetensi_id' => ['required', 'exists:m_unit_kompetensi,uuid'],
            'kriteria_unjuk_kerja_id' => ['required', 'exists:m_kriteria_unjuk_kerja,uuid'],
            'kunci_jawaban' => ['required','string'],
            'pertanyaan' => ['required'],
            'jawaban.*' => ['required']
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
        $piljab = [];
        foreach ($validated['jawaban'] as $data) {
            $piljab[] = $data;
        }
        $validated['jawaban'] = json_encode($piljab);
        $validated['unit_kompetensi_id'] = $unitKompetensi['id'];
        $validated['kriteria_unjuk_kerja_id'] = $kuk['id'];

        $data = TestTulis::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data test tulis berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $testTulis = TestTulis::with(['unitKompetensi','kriteriaUnjukKerja'])
            ->firstWhere('uuid', $uuid);
        if(!empty($testTulis)) {
            return response()->json(['status' => 'success', 'data' => $testTulis], 200);
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
            'kunci_jawaban' => ['required', 'string'],
            'pertanyaan' => ['required'],
            'jawaban.*' => ['required']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = TestTulis::firstWhere('uuid', $uuid);
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
        $piljab = [];
        foreach ($validated['jawaban'] as $jawaban) {
            $piljab[] = $jawaban;
        }
        $validated['jawaban'] = json_encode($piljab);
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
        $testTulis = TestTulis::where('uuid', $uuid);
        if(empty($testTulis->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data test tidak ditemukan'], 404);
        }
        if($testTulis->delete()) {
            return response()->json(['status' => 'success','message' => 'Data test berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data test gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = TestTulis::with(['unitKompetensi','kriteriaUnjukKerja'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = TestTulis::with(['unitKompetensi','kriteriaUnjukKerja'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $kriteriaUnjukKerjaId = KriteriaUnjukKerja::with(['testTulis','elemen'])
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($kriteriaUnjukKerjaId)) {
            $result = TestTulis::where('kriteria_unjuk_kerja_id', $kriteriaUnjukKerjaId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }
    }
}
