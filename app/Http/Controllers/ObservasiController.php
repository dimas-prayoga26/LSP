<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Storage,Gate,DB,Validator};
use App\Models\{KelompokAsesor,Asesi, Elemen, KriteriaUnjukKerja, Observasi, UnitKompetensi};

class ObservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uuid = request()->query->keys()[0];
        $query = KelompokAsesor::with(['skema.unitKompetensi.elemen','event','kelas','asesor.user']);

        if(Gate::allows('asesor') || Gate::allows('admin')) {
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
        return view('dashboard.checklistObservasiAsesi.index',compact('kelompokAsesor','kelompokAsesorNotIn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesor' => ['nullable'],
            'benchmark' => ['array'],
            'status_observasi' => ['required','array'],
            'penilaian_lanjut' => ['array'],
            'uuid' => ['required', 'exists:t_kelompok_asesor,uuid'],
            'asesi-id' => ['required','exists:m_asesi,uuid'],
            'umpan_balik' => ['nullable']
        ], $this->messageValidation());
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $request->uuid);
        $asesi = Asesi::firstWhere('uuid',request('asesi-id'));

        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }
        if(empty($asesi)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data asesi tidak ditemukan'], 404);
        }

        $existingData = Observasi::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if(empty($existingData)) {
            $request->validate([
                'signatureAsesor' => ['required']
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
            $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $validated['uuid']);
            if(empty($kelompokAsesor)) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
            }
            $arrFinalData = [];
            foreach ($validated['benchmark'] as $unitKomId => $b) {
                $unitKom = UnitKompetensi::firstWhere('id', $unitKomId);
                foreach ($b as $elemenId => $benchmark) {
                    $elemen = Elemen::firstWhere('id', $elemenId);
                    $arrStatusOberservasi = [];
                    foreach ($validated['status_observasi'] as $unitKomId2 => $c) {
                        if ($unitKomId !== $unitKomId2) continue;
                        foreach ($c as $elemenId2 => $arrKuk) {
                            if ($elemenId !== $elemenId2) continue;
                            foreach ($arrKuk as $kukId => $status) {
                                $kuk = KriteriaUnjukKerja::firstWhere('id', $kukId);
                                $arrStatusOberservasi[] = [
                                    'kriteria_unjuk_kerja_id' => $kuk['id'],
                                    'status_observasi' => $status
                                ];
                            }
                        }
                    }
                    $arrPenilaianLanjut = [];
                    foreach ($arrStatusOberservasi as $aso) {
                        foreach ($validated['penilaian_lanjut'] as $unitKomId3 => $d) {
                            if ($unitKomId !== $unitKomId3) continue;
                            foreach ($d as $elemenId3 => $arrKuk2) {
                                if ($elemenId !== $elemenId3) continue;
                                foreach ($arrKuk2 as $kukId3 => $keterangan) {
                                    if ($aso['kriteria_unjuk_kerja_id'] === $kukId3) {
                                        $arrPenilaianLanjut[] = [
                                            'kriteria_unjuk_kerja_id' => $aso['kriteria_unjuk_kerja_id'],
                                            'status_observasi' => $aso['status_observasi'],
                                            'penilaian_lanjutan' => $keterangan
                                        ];
                                    }
                                }
                            }
                        }
                    }

                    $arrFinalData[] = [
                        'unit_kompetensi_id' => $unitKom['id'],
                        'elemen_id' => $elemen['id'],
                        'benchmark' => $benchmark,
                        'observasi' => $arrPenilaianLanjut,
                    ];
                }
            }
            // TTD Asesor
            $signatureAsesor = $request->input('signatureAsesor');
            if($signatureAsesor) {
                // Hapus tanda tangan asesor jika ada
                if (!empty($existingData) && $existingData['ttd_asesor'] != null && Storage::exists($existingData['ttd_asesor'])) {
                    Storage::delete($existingData['ttd_asesor']);
                }

                // Tentukan nama dan path file untuk tanda tangan asesor
                $imageNameAsesor = time() . '.png';
                $directoryPathAsesor = public_path('storage/asesor_signatureChecklistObservasi');

                // Periksa jika direktori tidak ada, maka buat
                if (!is_dir($directoryPathAsesor)) {
                    mkdir($directoryPathAsesor, 0755, true); // Membuat direktori dengan izin 0755
                }

                // Tentukan path lengkap
                $pathAsesor = $directoryPathAsesor . '/' . $imageNameAsesor;

                // Proses dan simpan tanda tangan asesor
                $signatureAsesor = str_replace('data:image/png;base64,', '', $signatureAsesor);
                $signatureAsesor = str_replace(' ', '+', $signatureAsesor);
                file_put_contents($pathAsesor, base64_decode($signatureAsesor));

                // Simpan path ke dalam variabel untuk database
                $validated['ttd_asesor'] = 'asesor_signatureChecklistObservasi/' . $imageNameAsesor;
            } else {
                $validated['ttd_asesor'] = $existingData['ttd_asesor'];
            }
            $arrResult = [
                'asesi_id' => $asesi['id'],
                'kelompok_asesor_id' => $kelompokAsesor['id'],
                'jawaban' => json_encode($arrFinalData),
                'umpan_balik' => $validated['umpan_balik'],
                'ttd_asesor' => $validated['ttd_asesor'],
                'tgl_ttd_asesor' => now()
            ];

            $data =  Observasi::create($arrResult);
            if ($data) {
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Data observasi assesmen berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function asesiSignature(Request $request)
    {
        $signatureAsesi = $request->input('signature');
        $asesiUuid = $request->asesi_id;
        $kelompokAsesorUuid = $request->kelompok_asesor;
        DB::beginTransaction();
        $asesi = Asesi::firstWhere('uuid',$asesiUuid);
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid',$kelompokAsesorUuid);
        if(empty($asesi) || empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $observasi = Observasi::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if(empty($observasi)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Harap isi form sebelum melakukan tanda tangan'], 404);
        }

        if($signatureAsesi) {
            // Hapus tanda tangan asesi jika ada
            if (!empty($observasi) && $observasi['ttd_asesi'] != null && Storage::exists($observasi['ttd_asesi'])) {
                Storage::delete($observasi['ttd_asesi']);
            }

            // Tentukan nama dan path file untuk tanda tangan asesi
            $imageNameAsesi = time() . '.png';
            $directoryPathAsesi = public_path('storage/asesi_signatureChecklistObservasi');

            // Periksa jika direktori tidak ada, maka buat
            if (!is_dir($directoryPathAsesi)) {
                mkdir($directoryPathAsesi, 0755, true); // Membuat direktori dengan izin 0755
            }

            // Tentukan path lengkap
            $pathAsesi = $directoryPathAsesi . '/' . $imageNameAsesi;

            // Proses dan simpan tanda tangan asesi
            $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
            $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
            file_put_contents($pathAsesi, base64_decode($signatureAsesi));

            // Simpan path ke dalam variabel untuk database
            $resultTtdAsesi = 'asesi_signatureChecklistObservasi/' . $imageNameAsesi;
        } else {
            $resultTtdAsesi = $observasi['ttd_asesi'];
        }

        $result = $observasi->update([
            'tgl_ttd_asesi' => now(),
            'ttd_asesi' => $resultTtdAsesi
        ]);
        if ($result) {
            DB::commit();
            return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data Test Wawancara berhasil ditandatangani'], 200);
        } else {
            DB::rollBack();
            return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
        }
    }

    public function showByKelompokAsesor()
    {
        DB::beginTransaction();

        try {
            $kelompokAsesorUuid = request('kelompok_asesor');
            $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $kelompokAsesorUuid);

            if (empty($kelompokAsesor)) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
            }

            if (Gate::allows('asesi')) {
                $asesiId = Auth::user()->asesi['id'];
            } elseif (Gate::allows('asesor')  || Gate::allows('admin')) {
                $asesi = Asesi::firstWhere('uuid', request('asesi_id'));
                if ($asesi) {
                    $asesiId = $asesi->id;
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Data asesi tidak ditemukan'], 404);
                }
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Anda tidak memiliki izin untuk mengakses data ini'], 403);
            }

            $data = Observasi::where('asesi_id', $asesiId)
                ->where('kelompok_asesor_id', $kelompokAsesor->id)
                ->first();

            DB::commit();

            return response()->json(['status' => 'success', 'data' => $data], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }
}
