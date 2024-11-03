<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{KelompokAsesor,UserTestTulis,Asesi};
use Illuminate\Support\Facades\{Storage,Validator,Gate,Auth,DB};

class UserTestTulisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uuid = request()->query->keys()[0];
        if(Gate::allows('asesor')) {
            $uuid = explode('?', $uuid)[0];
        }
        $query = KelompokAsesor::with(['skema.unitKompetensi','skema.unitKompetensi.testTulis','event','kelas','asesor.user']);
        $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
        $kelompokAsesor = $query->firstWhere('uuid',$uuid);

        return view('dashboard.testAssesmen.testTulis.index',compact('kelompokAsesor','kelompokAsesorNotIn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesi' => ['nullable'],
            'jawabanTestTulisAsesi' => ['required'],
            'kelompok-asesor-uuid' => ['required', 'exists:t_kelompok_asesor,uuid']
        ], $this->messageValidation());

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', request('kelompok-asesor-uuid'));
        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        $existingData = UserTestTulis::firstWhere([
            ['asesi_id', Auth::user()->asesi['id']],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);

        if(empty($existingData)) {
            $request->validate([
                'signatureAsesi' => ['required'],
            ],$this->messageValidation());
        } else {
            return response()->json(['status' => 'error', 'message' => 'Kamu sudah melakukan submit sebelumnya'], 500);
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        try {
            DB::beginTransaction();

            // TTD Asesi
            $signatureAsesi = $request->input('signatureAsesi');
            if($signatureAsesi) {
                if(!empty($existingData) && $existingData['ttd_asesi'] != null && Storage::exists($existingData['ttd_asesi'])) {
                    Storage::delete($existingData['ttd_asesi']);
                }
                $imageName = time() . '.png';
                $path = public_path('storage/asesi_signatureTestTulis/' . $imageName);
                $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
                $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
                file_put_contents($path, base64_decode($signatureAsesi));
                $validated['ttd_asesi'] = 'asesi_signatureTestTulis/'.$imageName;
            } else {
                $validated['ttd_asesi'] = $existingData['ttd_asesi'];
            }

            // Loop Test Tulis
            $arrJawabanData = [];
            if (isset($validated['jawabanTestTulisAsesi'])) :
                foreach ($validated['jawabanTestTulisAsesi'] as $unitKompetensiId => $data) {
                    foreach($data as $soalId => $jawaban) {
                        $arrJawabanData[] = [
                            'unit_kompetensi_id' => $unitKompetensiId,
                            'test_tulis_id' => $soalId,
                            'jawaban' => $jawaban
                        ];
                    }
                }
            endif;

            $validated['jawaban'] = json_encode($arrJawabanData);
            $validated['asesi_id'] = Auth::user()->asesi['id'];
            $validated['tgl_ttd_asesi'] = now();

            $result = UserTestTulis::updateOrCreate([
                    'asesi_id' => Auth::user()->asesi['id'],
                    'kelompok_asesor_id' => $kelompokAsesor['id']
                ],
                [
                    'ttd_asesi' => $validated['ttd_asesi'],
                    'jawaban' => $validated['jawaban'],
                    'asesi_id' => $validated['asesi_id'],
                    'tgl_ttd_asesi' => $validated['tgl_ttd_asesi']
                ]);
            if ($result) {
                DB::commit();
                return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data Test Tulis berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error','code' => '500', 'message' => $th->getMessage()], 500);
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

        $userTestTulis = UserTestTulis::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if($signatureAsesor) {
            if(!empty($userTestTulis) && $userTestTulis['ttd_asesor'] != null && Storage::exists($userTestTulis['ttd_asesor'])) {
                Storage::delete($userTestTulis['ttd_asesor']);
            }
            $imageName = time() . '.png';
            $path = public_path('storage/asesor_signatureTestTulis/' . $imageName);
            $signatureAsesor = str_replace('data:image/png;base64,', '', $signatureAsesor);
            $signatureAsesor = str_replace(' ', '+', $signatureAsesor);
            file_put_contents($path, base64_decode($signatureAsesor));
            $resultTtdAsesor = 'asesor_signatureTestTulis/'.$imageName;
        } else {
            $resultTtdAsesor = $userTestTulis['ttd_asesor'];
        }

        $result = $userTestTulis->update([
            'tgl_ttd_asesor' => now(),
            'ttd_asesor' => $resultTtdAsesor
        ]);
        if ($result) {
            DB::commit();
            return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data Test Tulis berhasil ditandatangani'], 200);
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
        $data = UserTestTulis::firstWhere([
            ['asesi_id', $asesiId],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
