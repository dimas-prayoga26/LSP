<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Asesi;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;    

class EventAsesorController extends Controller
{
    public function show($uuid)
    {
        $asesor_id = Auth::user()->asesor['id'];
        $current_time = Carbon::now();
        $query = KelompokAsesor::query();
        $singleDataKelompokAsesor = (clone $query)->with('event')->firstWhere('uuid',$uuid)->event['nama_event'];
        $kelompokAsesor = $query->where([['asesor_id', $asesor_id],['uuid', '!=', $uuid]])
            ->whereHas('event', function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            })
            ->with(['event' => function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            }])
            ->get();
        return view('dashboard.eventAsesor.index',compact('kelompokAsesor','singleDataKelompokAsesor'));
    }

    public function datatable($uuid)
    {
        $asesor_id = Auth::user()->asesor['id'];
        $kelompokAsesor = KelompokAsesor::with(['skema','event','kelas.asesi.user','asesor.user'])->firstWhere([
            ['uuid',$uuid],
            ['asesor_id', $asesor_id]
        ]);
        $data = $kelompokAsesor;
        // $data = $kelompokAsesor->kelas->asesi;

        // dd($data);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function updateQualificationStatus(Request $request, $uuid)
    {
        // Debug untuk melihat isi request
        // dd($request->all());

        // Validasi input
        $request->validate([
            'asesi_id' => 'required|exists:m_asesi,id',
            'kelompok_asesor_id' => 'required|exists:t_kelompok_asesor,id',
            'is_qualification' => 'required|in:Kompeten,Belum Kompeten',
        ]);
        

        // Temukan kelompok asesor berdasarkan ID
        // Ubah pencarian menjadi berdasarkan uuid, bukan id
        $kelompokAsesor = Asesi::where('id', $request->input('asesi_id'))->firstOrFail();

        // Update status dan valid_date dengan tanggal sekarang
        $kelompokAsesor->is_qualification = $request->input('is_qualification');
        $kelompokAsesor->valid_date = now(); // Mengisi valid_date dengan tanggal sekarang
        $kelompokAsesor->save();

        // Cek apakah sudah ada sertifikat untuk asesi dan kelompok_asesor ini
        $existingCertificate = Certificate::where('asesi_id', $kelompokAsesor->id)
                                        ->where('kelompok_asesor_id', $request->input('kelompok_asesor_id'))
                                        ->first();

                                        // dd($kelompokAsesor->uuid);
        if (!$existingCertificate) {
            // Jika belum ada, buat sertifikat baru
            Certificate::create([
                'asesi_id' => $kelompokAsesor->id,
                'kelompok_asesor_id' => $request->input('kelompok_asesor_id'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kembalikan respons sukses
        return response()->json(['status' => 'success', 'message' => 'Status, valid date, dan sertifikat berhasil diperbarui'], 200);
    }



}
