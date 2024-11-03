<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;

class EventAsesiController extends Controller
{
    public function show($uuid)
    {
        $kelas_id = Auth::user()->asesi['kelas_id'];
        $current_time = Carbon::now();
        $query = KelompokAsesor::query();
        $singleDataKelompokAsesor = (clone $query)->with('event')->firstWhere('uuid',$uuid)->event['nama_event'];
        $kelompokAsesor = $query->where([['kelas_id', $kelas_id],['uuid','!=',$uuid]])
            ->whereHas('event', function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            })
            ->with(['event' => function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            }])
            ->get();
        return view('dashboard.eventAsesi.index',compact('kelompokAsesor','singleDataKelompokAsesor'));
    }

    public function datatable($uuid)
{
    $kelas_id = Auth::user()->asesi['kelas_id'];

    // Ambil data Kelompok Asesor beserta relasi
    $data = KelompokAsesor::with([
        'skema', 
        'event', 
        'kelas', 
        'asesor.user', 
        'certificates'
    ])->where([
        ['uuid', $uuid],
        ['kelas_id', $kelas_id]
    ])->get();

    // Map data dan tambahkan 'uuid' serta 'certificates' jika ada
    $responseData = $data->map(function ($kelompok) {
        return [
            'uuid' => $kelompok->uuid,
            'skema' => $kelompok->skema,
            'event' => $kelompok->event,
            'kelas' => $kelompok->kelas,
            'asesor' => $kelompok->asesor->user,
            'certificates' => $kelompok->certificates->map(function ($certificate) {
                return [
                    'id' => $certificate->id,
                    'file_certificate' => $certificate->file_certificate, // Path sertifikat
                    // 'name' => $certificate->name // Nama sertifikat
                ];
            }),
        ];
    });

    return response()->json(['status' => 'success', 'data' => $responseData], 200);
}
    
    public function downloadCertificate($uuid, $id)
    {
        // Cari sertifikat berdasarkan ID
        $certificate = Certificate::find($id);

        // Jika sertifikat tidak ditemukan atau file_certificate null
        if (is_null($certificate) || is_null($certificate->file_certificate)) {
            return response()->json(['status' => 'error', 'message' => 'Sertifikat belum dibagikan'], 400);
        }

        // Path ke file sertifikat di storage
        $pathToFile = storage_path('app/public/' . $certificate->file_certificate);

        // Cek apakah file ada di server
        if (!file_exists($pathToFile)) {
            return response()->json(['status' => 'error', 'message' => 'File sertifikat tidak ditemukan'], 404);
        }

        // Jika file ditemukan, berikan status sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Sertifikat berhasil didownload',
            'download_url' => url('storage/' . $certificate->file_certificate) // URL untuk mengunduh file
        ]);
    }

}
