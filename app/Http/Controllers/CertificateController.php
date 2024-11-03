<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{

    public function index()
    {
        return view('dashboard.sertifikasi.index');
    }

    /**
     * Handle the incoming request.
     */
    public function datatable()
    {
        $data = Certificate::with([
            'asesi',
            'asesi.user', 
            'kelompokAsesor',
            'kelompokAsesor.asesor',
            'kelompokAsesor.asesor.user'
            ])->latest()->get();

        // dd($data);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function generateCertificate($certificateId)
    {
        Log::info('Certificate ID yang dikirim: ' . $certificateId);

        $certificate = Certificate::with('asesi.user', 'kelompokAsesor.event', 'kelompokAsesor.skema')
                                    ->where('uuid', $certificateId)
                                    ->firstOrFail();

        $oldFile = $certificate->file_certificate;

        if ($oldFile && Storage::exists('public/' . $oldFile)) {
            Storage::delete('public/' . $oldFile);
        }


        $skill = $certificate->kelompokAsesor->event->nama_event; 
        $skillEng = $skill;
        
        $data = [
            'name' => $certificate->asesi->user->name,
            'noreg' => 'No. Reg. TIK 1565 04115 2024',
            'skill' => $skill, 
            'skillEng' => $skillEng, 
            'skill2' => $certificate->kelompokAsesor->skema->judul_skema,
            'date' => $certificate->asesi->valid_date ? Carbon::parse($certificate->asesi->valid_date)->translatedFormat('d F Y') : 'Tanggal tidak tersedia',
        ];

        // Generate nama file baru untuk sertifikat
        $pdfFileName = 'sertifikat-' . Str::slug($certificate->asesi->user->name) . '.pdf';

        // Render PDF menggunakan data yang sudah diambil
        $pdf = Pdf::loadView('certificate.index', $data)->setPaper('A4', 'portrait');

        // Simpan PDF ke dalam folder public/storage/certificate
        $pdfContent = $pdf->output();
        Storage::put('public/certificate/' . $pdfFileName, $pdfContent);

        // Simpan path file PDF ke dalam kolom file_certificate di database
        $certificate->update([
            'file_certificate' => 'certificate/' . $pdfFileName,  // Path disimpan di database dengan format 'certificate/{nama file}'
        ]);

        return response()->json(['message' => 'PDF has been generated and saved successfully!', 'pdf_path' => asset('storage/certificate/' . $pdfFileName)]);
    }

    public function exportPdf()
    {
        // Ambil data sertifikat yang ingin diexport ke PDF
        $certificates = Certificate::with(['asesi.user', 'kelompokAsesor.event', 'kelompokAsesor.skema'])->get();

        // Data yang akan diteruskan ke view
        $data = [
            'certificates' => $certificates
        ];

        // Render PDF menggunakan view
        $pdf = PDF::loadView('pdf.certificates', $data);

        // Download file PDF
        return $pdf->download('sertifikat-' . now()->format('Y-m-d') . '.pdf');
    }
}
