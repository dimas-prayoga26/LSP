<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.jurusan.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jurusan' => ['required', 'string', 'max:255','unique:m_jurusan,nama_jurusan'],
            'keterangan' => ['required','string','max:255'],
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data =  Jurusan::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data jurusan berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $jurusan = Jurusan::with('kelas')
        ->where('uuid', $uuid)
        ->first();
        if(!empty($jurusan)) {
            return response()->json(['status' => 'success', 'data' => $jurusan], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data jurusan tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama_jurusan' => ['required', 'string', 'max:255','unique:m_jurusan,nama_jurusan,'.$uuid.',uuid'],
            'keterangan' => ['required','string','max:255']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $data = Jurusan::where('uuid', $uuid)
            ->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data jurusan tidak ditemukan'], 404);
        }
        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data jurusan berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $jurusan = Jurusan::where('uuid', $uuid);
        if(empty($jurusan->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data jurusan tidak ditemukan'], 404);
        }
        if($jurusan->delete()) {
            return response()->json(['status' => 'success','message' => 'Data jurusan berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data jurusan gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = Jurusan::with('kelas')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Jurusan::with('kelas')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
