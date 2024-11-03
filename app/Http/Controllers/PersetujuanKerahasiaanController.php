<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Asesi,Asesor,KelompokAsesor,PersetujuanKerahasiaan};
use Illuminate\Support\Facades\{Gate,Auth,DB,Storage,Validator};
use App\Http\Requests\UpdatePersetujuanKerahasiaanRequest;

class PersetujuanKerahasiaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uuid = request()->query->keys()[0];
        $query = KelompokAsesor::with(['skema.unitKompetensi.elemen','event','kelas','asesor.user']);

        if(Gate::allows('asesor')) {
            $asesi = Asesi::firstWhere('uuid',$uuid);
            $kelompokAsesorId = request('kelompok-asesor-id');
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$kelompokAsesorId)->get();
            $kelompokAsesor = $query->where([
                ['kelas_id',$asesi['kelas_id']],
                ['uuid', $kelompokAsesorId]
            ])->first();
        } elseif (Gate::allows('asesi')) {
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
            $kelompokAsesor = $query->firstWhere('uuid',$uuid);
        }
        return view('dashboard.lembarPersetujuanAsesi.index',compact('kelompokAsesor','kelompokAsesorNotIn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesi' => ['nullable'],
            'berkas.*' => ['required'],
            'uuid' => ['required', 'exists:t_kelompok_asesor,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        try {
            DB::beginTransaction();
            $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $validated['uuid']);
            if(empty($kelompokAsesor)) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
            }

            $berkas = [];
            foreach ($validated['berkas'] as $val) {
                $berkas[] = $val;
            }
            $validated['berkas'] = json_encode($berkas);
            $validated['asesi_id'] = Auth::user()->asesi['id'];
            $validated['tgl_ttd_asesi'] = now();

            $existingData = PersetujuanKerahasiaan::firstWhere([
                ['asesi_id', Auth::user()->asesi['id']],
                ['kelompok_asesor_id', $kelompokAsesor['id']]
            ]);

            if(empty($existingData)) {
                $request->validate([
                    'signatureAsesi' => ['required']
                ],$this->messageValidation());
            } else {
                return response()->json(['status' => 'error', 'message' => 'Kamu sudah melakukan submit sebelumnya'], 500);
            }
            // TTD Asesi
            $signatureAsesi = $request->input('signatureAsesi');
            if($signatureAsesi) {
                if(!empty($existingData) && $existingData['ttd_asesi'] != null && Storage::exists($existingData['ttd_asesi'])) {
                    Storage::delete($existingData['ttd_asesi']);
                }
                $imageName = time() . '.png';
                $path = public_path('storage/asesi_signaturePersetujuanKerahasiaan/' . $imageName);
                $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
                $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
                file_put_contents($path, base64_decode($signatureAsesi));
                $validated['ttd_asesi'] = 'asesi_signaturePersetujuanKerahasiaan/'.$imageName;
            } else {
                $validated['ttd_asesi'] = $existingData['ttd_asesi'];
            }

            $data =  PersetujuanKerahasiaan::updateOrCreate([
                    'asesi_id' => Auth::user()->asesi['id'],
                    'kelompok_asesor_id' => $kelompokAsesor['id']
                ],
                [
                    'berkas' => $validated['berkas'],
                    'ttd_asesi' => $validated['ttd_asesi'],
                    'tgl_ttd_asesi' => $validated['tgl_ttd_asesi']
                ]);
            if ($data) {
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Data persetujuan assesmen berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    public function asesorSignature(Request $request)
    {
        $signatureAsesor = $request->input('signature');
        $asesiUuid = $request->asesi_id;
        $kelompokAsesorUuid = $request->kelompok_asesor;
        DB::beginTransaction();
        $asesi = Asesi::firstWhere('uuid',$asesiUuid);
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid',$kelompokAsesorUuid);
        if(empty($asesi) || empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $persetujuanAssesmen = PersetujuanKerahasiaan::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if($signatureAsesor) {
            if(!empty($persetujuanAssesmen) && $persetujuanAssesmen['ttd_asesor'] != null && Storage::exists($persetujuanAssesmen['ttd_asesor'])) {
                Storage::delete($persetujuanAssesmen['ttd_asesor']);
            }
            $imageName = time() . '.png';
            $path = public_path('storage/asesor_signaturePersetujuanKerahasiaan/' . $imageName);
            $signatureAsesor = str_replace('data:image/png;base64,', '', $signatureAsesor);
            $signatureAsesor = str_replace(' ', '+', $signatureAsesor);
            file_put_contents($path, base64_decode($signatureAsesor));
            $resultTtdAsesor = 'asesor_signaturePersetujuanKerahasiaan/'.$imageName;
        } else {
            $resultTtdAsesor = $persetujuanAssesmen['ttd_asesor'];
        }

        $result = $persetujuanAssesmen->update([
            'tgl_ttd_asesor' => now(),
            'ttd_asesor' => $resultTtdAsesor
        ]);

        if ($result) {
            DB::commit();
            return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data persetujuan assesmen berhasil ditandatangani'], 200);
        } else {
            DB::rollBack();
            return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
        }
    }

    public function showByKelompokAsesor()
    {
        $kelompokAsesorUuid = request('kelompok_asesor');

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $kelompokAsesorUuid);
        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        if(Gate::allows('asesi')) {
            $asesiId = Auth::user()->asesi['id'];
        } elseif (Gate::allows('asesor')) {
            $asesiId = Asesi::firstWhere('uuid',request('asesi_id'))->pluck('id');
        }

        $data = PersetujuanKerahasiaan::firstWhere([
            'asesi_id' => $asesiId,
            'kelompok_asesor_id' => $kelompokAsesor['id']
        ]);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersetujuanKerahasiaanRequest $request, PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
    }

    public function datatable()
    {
        $data = PersetujuanKerahasiaan::with(['asesor','asesi','skema'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = PersetujuanKerahasiaan::with(['asesor','asesi','skema'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByAsesorUUID($uuid)
    {
        $asesorId = Asesor::with('user')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($asesorId)) {
            $result = PersetujuanKerahasiaan::with(['asesor','asesi.user.name','skema'])
            ->where('asesor_id', $asesorId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
    }

    public function listByAsesiUUID($uuid)
    {
        $asesiId = Asesi::with('user')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($asesiId)) {
            $result = PersetujuanKerahasiaan::with(['asesor.user.name','asesi','skema'])
            ->where('asesi_id', $asesiId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data asesi tidak ditemukan'], 404);
        }
    }
}
