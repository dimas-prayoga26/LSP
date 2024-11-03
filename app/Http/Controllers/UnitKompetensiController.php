<?php

namespace App\Http\Controllers;

use App\Models\{UnitKompetensi,Skema};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.unitKompetensi.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_standar' => ['required','in:KKNI,Okupasi,Klaster'],
            'kode_unit' => ['required','unique:m_unit_kompetensi,kode_unit'],
            'judul_unit' => ['required', 'string', 'max:255'],
            'skema_id' => ['required', 'exists:m_skema,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $skema = Skema::where('uuid', $validated['skema_id'])->first();
        if(empty($skema)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        $validated['skema_id'] = $skema['id'];
        $data =  UnitKompetensi::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data unit kompetensi berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $uk = UnitKompetensi::with(['skema','elemen'])
            ->where('uuid', $uuid)
            ->first();
        if(!empty($uk)) {
            return response()->json(['status' => 'success', 'data' => $uk], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'jenis_standar' => ['required','in:KKNI,Okupasi,Klaster'],
            'kode_unit' => ['required','unique:m_unit_kompetensi,kode_unit,'. $uuid . ',uuid'],
            'judul_unit' => ['required', 'string', 'max:255'],
            'skema_id' => ['required', 'exists:m_skema,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = UnitKompetensi::with(['skema','elemen'])->where('uuid', $uuid)->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }

        $skema = Skema::where('uuid', $validated['skema_id'])->first();
        if(empty($skema)) {
            return response()->json(['status' => 'error', 'message' => 'Data skema tidak ditemukan'], 404);
        }
        $validated['skema_id'] = $skema['id'];

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data unit kompetensi berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $uk = UnitKompetensi::with(['skema','elemen'])->where('uuid', $uuid);
        if(empty($uk->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi tidak ditemukan'], 404);
        }
        if($uk->delete()) {
            return response()->json(['status' => 'success','message' => 'Data unit kompetensi berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data unit kompetensi gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = UnitKompetensi::with(['skema','elemen'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = UnitKompetensi::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $skmeId = Skema::where('uuid',$uuid)->pluck('id');
        if(isset($skmeId)) {
            $result = UnitKompetensi::with(['skema','elemen'])->where('skema_id', $skmeId)->latest()->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data skema tidak ditemukan'], 404);
        }
    }
}
