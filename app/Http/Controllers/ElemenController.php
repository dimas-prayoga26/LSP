<?php

namespace App\Http\Controllers;

use App\Models\{Elemen,UnitKompetensi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.elemen.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_elemen' => ['required', 'string', 'max:255'],
            'unit_kompetensi_id' => ['required', 'exists:m_unit_kompetensi,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $unitKompetensi = UnitKompetensi::where('uuid', $validated['unit_kompetensi_id'])->first();
        if(empty($unitKompetensi)) {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }
        $validated['unit_kompetensi_id'] = (int) $unitKompetensi['id'];
        $data =  Elemen::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data elemen berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $elemen = Elemen::with(['unitKompetensi','kriteriaUnjukKerja'])
            ->where('uuid', $uuid)
            ->first();
        if(!empty($elemen)) {
            return response()->json(['status' => 'success', 'data' => $elemen], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data elemen tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama_elemen' => ['required', 'string', 'max:255'],
            'unit_kompetensi_id' => ['required', 'exists:m_unit_kompetensi,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = Elemen::where('uuid', $uuid)
            ->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data elemen tidak ditemukan'], 404);
        }

        $unitKompetensi = UnitKompetensi::where('uuid', $validated['unit_kompetensi_id'])->first();
        if(empty($unitKompetensi)) {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }
        $validated['unit_kompetensi_id'] = (int) $unitKompetensi['id'];

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data elemen berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $elemen = Elemen::where('uuid', $uuid);
        if(empty($elemen->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data elemen tidak ditemukan'], 404);
        }
        if($elemen->delete()) {
            return response()->json(['status' => 'success','message' => 'Data elemen berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data elemen gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = Elemen::with(['unitKompetensi','kriteriaUnjukKerja'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Elemen::with(['unitKompetensi','kriteriaUnjukKerja'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $unitKompetensiId = UnitKompetensi::with(['skema','elemen'])
        ->where('uuid',$uuid)
        ->pluck('id');
        if(isset($unitKompetensiId)) {
            $result = Elemen::with(['unitKompetensi','kriteriaUnjukKerja'])
                ->where('unit_kompetensi_id', $unitKompetensiId)
                ->latest()
                ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data skema tidak ditemukan'], 404);
        }
    }
}