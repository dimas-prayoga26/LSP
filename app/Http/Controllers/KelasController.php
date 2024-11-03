<?php

namespace App\Http\Controllers;

use App\Models\{Kelas,Jurusan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.kelas.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => ['required', 'string', 'max:255'],
            'keterangan' => ['required','string','max:255'],
            'jurusan_id' => ['required', 'exists:m_jurusan,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $jurusan = Jurusan::where('uuid', $validated['jurusan_id'])->first();
        if(empty($jurusan)) {
            return response()->json(['status' => 'error', 'message' => 'Data jurusan tidak ditemukan'], 404);
        }
        $validated['jurusan_id'] = (int) $jurusan['id'];

        $data =  Kelas::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data kelas berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $kelas = Kelas::with(['kelompokAsesor','jurusan'])
        ->firstWhere('uuid', $uuid);
        if(!empty($kelas)) {
            return response()->json(['status' => 'success', 'data' => $kelas], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => ['required', 'string', 'max:255'],
            'keterangan' => ['required','string','max:255'],
            'jurusan_id' => ['required', 'exists:m_jurusan,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = Kelas::firstWhere('uuid', $uuid);
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
        }

        $jurusan = Jurusan::firstWhere('uuid', $validated['jurusan_id']);
        if(empty($jurusan)) {
            return response()->json(['status' => 'error', 'message' => 'Data jurusan tidak ditemukan'], 404);
        }
        $validated['jurusan_id'] = (int) $jurusan['id'];

        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data kelas berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $kelas = Kelas::where('uuid', $uuid);
        if(empty($kelas->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
        }
        if($kelas->delete()) {
            return response()->json(['status' => 'success','message' => 'Data kelas berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data kelas gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = Kelas::with(['kelompokAsesor','jurusan'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Kelas::with(['kelompokAsesor','jurusan'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $jurusanId = Jurusan::with('kelas')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($jurusanId)) {
            $result = Kelas::where('jurusan_id', $jurusanId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data jurusan tidak ditemukan'], 404);
        }
    }
}
