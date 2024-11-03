<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{KelompokAsesor,FRAPL01};
use Illuminate\Support\Facades\{Auth,DB,Gate,Validator};

class FRAPL01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uuid = request()->query->keys()[0];
        if(Gate::allows('asesor') || Gate::allows('admin')) {
            $uuid = explode('?', $uuid)[0];
        }
        $query = KelompokAsesor::with(['skema.berkasPermohonan','event','kelas','asesor.user']);
        $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
        $kelompokAsesor = $query->firstWhere('uuid',$uuid);

        // Get the current logged-in user
        $user = Auth::user();
        $isAsesi = $user->role === 'Asesi';  // Check if the user's role is 'asesi'

        return view('dashboard.frapl.frapl01.index', compact('kelompokAsesor', 'kelompokAsesorNotIn', 'user', 'isAsesi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Existing
            'name' => 'required|string|max:255|exists:users,name',
            'email' => 'required|lowercase|email|exists:users,email|max:255',
            'address'=> ['required','string','max:255'],
            'phone'=> ['required','regex:/(08)[0-9]{9}/','max:20','exists:users,phone'],
            'jenis_kelamin'=> ['required','in:Laki-laki,Perempuan','exists:users,jenis_kelamin'],
            // Non Existing
            'no_ktp'=>['required','numeric','unique:t_frapl01,no_ktp,'.Auth::user()->asesi['id'] .',asesi_id'],
            'tempat_lahir'=>['required','string','max:255'],
            'kebangsaan'=>['required','string','max:255'],
            'alamat_kantor'=>['nullable','string','max:255'],
            'kode_pos'=>['required','numeric'],
            'tlp_rumah'=>['nullable','string','max:255','unique:t_frapl01,tlp_rumah,'.Auth::user()->asesi['id'] .',asesi_id'],
            'tlp_kantor'=>['nullable','string','max:255','unique:t_frapl01,tlp_kantor,'.Auth::user()->asesi['id'] .',asesi_id'],
            'pendidikan' => ['required','string','max:255'],
            'nama_institusi' => ['nullable','string','max:255'],
            'jabatan' => ['nullable','string','max:255'],
            'no_tlp_institusi' => ['nullable','string','max:255','unique:t_frapl01,no_tlp_institusi,'.Auth::user()->asesi['id'] .',asesi_id'],
            'kode_pos_institusi' => ['nullable','numeric'],
            'email_institusi' => ['nullable','email','lowercase','unique:t_frapl01,email_institusi,'.Auth::user()->asesi['id'] .',asesi_id'],
            'fax' => ['nullable','string','max:255'],
            'tujuan_assesmen' => ['required','in:Sertifikasi,Sertifikasi Ulang,Pengakuan Kompetensi Terkini (PKT),Rekognisi Pembelajaran Lampau,Lainnya'],
            'tgl_lahir'=>['required','date'],
            'signatureAsesi' => ['nullable'],
            'berkasFilePemohon' => ['nullable'],
            'statusBerkasPemohon' => ['required'],
            'kelompok-asesor-uuid' => ['required', 'exists:t_kelompok_asesor,uuid']
        ], $this->messageValidation());

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', request('kelompok-asesor-uuid'));
        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        $existingData = FRAPL01::firstWhere([
            ['asesi_id', Auth::user()->asesi['id']],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);

        if(empty($existingData)) {
            $request->validate([
                'signatureAsesi' => ['required'],
                'berkasFilePemohon' => ['required']
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
            if ($signatureAsesi) {
                if (!empty($existingData) && $existingData['ttd_asesi'] != null && Storage::exists($existingData['ttd_asesi'])) {
                    Storage::delete($existingData['ttd_asesi']);
                }

                $imageName = time() . '.png';
                $directoryPath = public_path('storage/asesi_signatureFRAPL01');

                if (!is_dir($directoryPath)) {
                    mkdir($directoryPath, 0755, true);
                }

                $path = $directoryPath . '/' . $imageName;

                $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
                $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
                file_put_contents($path, base64_decode($signatureAsesi));

                $validated['ttd_asesi'] = 'asesi_signatureFRAPL01/' . $imageName;
            } else {
                $validated['ttd_asesi'] = $existingData['ttd_asesi'];
            }


            if(isset($validated['berkasFilePemohon']) && !empty($existingData)) {
                $jcdBerkas = json_decode($existingData['berkas_pemohon_asesi'],true);
                foreach($jcdBerkas as $berkas) {
                    Storage::delete($berkas['berkas']);
                }
                $existingData->update(['berkas_pemohon_asesi' => json_encode([])]);
            }

            // Loop Berkas & File
            $arrStatusBerkas = [];
            if (isset($validated['statusBerkasPemohon'])) :
                foreach ($validated['statusBerkasPemohon'] as $keterangan) {
                    $arrStatusBerkas[] = [
                        'keterangan' => $keterangan
                    ];
                }
            endif;
            $arrFileBerkas = [];
            if (isset($validated['berkasFilePemohon'])) :
                foreach ($validated['berkasFilePemohon'] as $b) {
                    $path = $b->store('berkas_frpapl01');
                    $arrFileBerkas[] = [
                        'berkas' => $path
                    ];
                }
                for ($i = 0; $i < count($validated['berkasFilePemohon']); $i++) {
                    $mergedBerkas[] = array_merge($arrStatusBerkas[$i], $arrFileBerkas[$i]);
                }
            else:
                $jcdBerkas = json_decode($existingData['berkas_pemohon_asesi'],true);
                $mergedBerkas = $jcdBerkas;
            endif;


            $validated['berkas_pemohon_asesi'] = json_encode($mergedBerkas);
            $validated['asesi_id'] = Auth::user()->asesi['id'];
            $validated['tgl_ttd_asesi'] = now();

            $result = FRAPL01::updateOrCreate([
                    'asesi_id' => Auth::user()->asesi['id'],
                    'kelompok_asesor_id' => $kelompokAsesor['id']
                ],
                [
                    'no_ktp' => $validated['no_ktp'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'kebangsaan' => $validated['kebangsaan'],
                    'alamat_kantor' => $validated['alamat_kantor'],
                    'kode_pos' => $validated['kode_pos'],
                    'tlp_rumah' => $validated['tlp_rumah'],
                    'tlp_kantor' => $validated['tlp_kantor'],
                    'pendidikan' => $validated['pendidikan'],
                    'nama_institusi' => $validated['nama_institusi'],
                    'jabatan' => $validated['jabatan'],
                    'no_tlp_institusi' => $validated['no_tlp_institusi'],
                    'kode_pos_institusi' => $validated['kode_pos_institusi'],
                    'email_institusi' => $validated['email_institusi'],
                    'fax' => $validated['fax'],
                    'tujuan_assesmen' => $validated['tujuan_assesmen'],
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'ttd_asesi' => $validated['ttd_asesi'],
                    'berkas_pemohon_asesi' => $validated['berkas_pemohon_asesi'],
                    'asesi_id' => $validated['asesi_id'],
                    'tgl_ttd_asesi' => $validated['tgl_ttd_asesi']
                ]);
            if ($result) {
                DB::commit();
                return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data FRAPL-01 berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error','code' => '500', 'message' => $th->getMessage()], 500);
        }
    }

    public function adminSignature(Request $request)
    {
        $signatureAdminLSP = $request->input('signature');
        $asesiUuid = $request->asesi_id;
        $kelompokAsesorUuid = $request->kelompok_asesor;
        DB::beginTransaction();
        $asesi = Asesi::firstWhere('uuid',$asesiUuid);
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid',$kelompokAsesorUuid);
        if(empty($asesi) || empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $frapl01 = FRAPL01::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if($signatureAdminLSP) {
            // Hapus tanda tangan admin LSP jika ada
            if (!empty($frapl01) && $frapl01['ttd_admin_lsp'] != null && Storage::exists($frapl01['ttd_admin_lsp'])) {
                Storage::delete($frapl01['ttd_admin_lsp']);
            }

            // Tentukan nama dan path file untuk tanda tangan admin LSP
            $imageName = time() . '.png';
            $directoryPath = public_path('storage/adminLSP_signatureFRAPL01');

            // Periksa jika direktori tidak ada, maka buat
            if (!is_dir($directoryPath)) {
                mkdir($directoryPath, 0755, true); // Membuat direktori dengan izin 0755
            }

            // Tentukan path lengkap
            $path = $directoryPath . '/' . $imageName;

            // Proses dan simpan tanda tangan admin LSP
            $signatureAdminLSP = str_replace('data:image/png;base64,', '', $signatureAdminLSP);
            $signatureAdminLSP = str_replace(' ', '+', $signatureAdminLSP);
            file_put_contents($path, base64_decode($signatureAdminLSP));

            // Simpan path ke dalam variabel untuk database
            $resultTtdAdminLSP = 'adminLSP_signatureFRAPL01/' . $imageName;

        } else {
            $resultTtdAdminLSP = $frapl01['ttd_admin_lsp'];
        }

        $result = $frapl01->update([
            'tgl_ttd_admin_lsp' => now(),
            'ttd_admin_lsp' => $resultTtdAdminLSP
        ]);

        if ($result) {
            DB::commit();
            return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data frapl01 assesmen berhasil ditandatangani'], 200);
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
            } elseif (Gate::allows('asesor') || Gate::allows('admin')) {
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

            $data = FRAPL01::with('asesi.user')->firstWhere([
                ['asesi_id', $asesiId],
                ['kelompok_asesor_id', $kelompokAsesor->id]
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'data' => $data], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
