<?php

use App\Http\Controllers\{
    AsesiController,
    AsesorController,
    BerkasPemohonController,
    ElemenController,
    EventAdminController,
    EventAsesiController,
    EventAsesorController,
    EventController,
    FRAPL01Controller,
    FRAPL02Controller,
    FRAPLcontroller,
    JurusanController,
    GuestController,
    KelasController,
    KelompokAsesorController,
    KriteriaUnjukKerjaController,
    ObservasiController,
    PengaturanConctroller,
    PersetujuanKerahasiaanController,
    ProfileController,
    SkemaController,
    TestAssesmenController,
    TestPraktekController,
    TestTulisController,
    TestWawancaraController,
    UnitKompetensiController,
    UserTestPraktekController,
    UserTestTulisController,
    UserTestWawancaraController,
    DashboardController,
    CertificateController,
};
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Facades\Captcha;

// Root
Route::get('/certificate-preview', function () {
    return view('certificate.index'); // This will directly load the certificate preview view
})->name('certificate.preview');

Route::get('/', [GuestController::class,'index'])->name('guest.index');
Route::get('/assesmen-register',[GuestController::class,'registerAssesmen'])->name('guest.assesmen-register');
Route::get('kelas/list/{uuid}', [KelasController::class, 'listByUUID'])->name('kelas.listByUuid');
Route::get('/captcha-refresh', function () {
    return response()->json(['captcha' => Captcha::img()]);
});

Route::middleware('auth')->group(function () {
    // Admin Middleware
    Route::middleware('can:admin')->group(function() {
        // Kelompok Asesor
        Route::resource('kelompok-asesor', KelompokAsesorController::class)->names('kelompokAsesor')->except(['create', 'show']);
        Route::prefix('kelompok-asesor')->group(function () {
            Route::get('datatable', [KelompokAsesorController::class, 'datatable'])->name('kelompokAsesor.datatable');
            Route::get('list',[KelompokAsesorController::class,'list'])->name('kelompokAsesor.list');
        });
        // Event
        Route::resource('event', EventController::class)->except(['create', 'show']);
        Route::prefix('event')->group(function () {
            Route::get('datatable', [EventController::class, 'datatable'])->name('event.datatable');
            Route::get('list',[EventController::class,'list'])->name('event.list');
        });
        // Event Admin
        Route::prefix('event-admin')->group(function () {
            Route::get('',[EventAdminController::class,'index'])->name('event-admin.index');
            Route::get('{uuid}/datatable', [EventAdminController::class, 'datatable'])->name('event-admin.datatable');
        });
        // Skema
        Route::resource('skema', SkemaController::class)->except(['create', 'show']);
        Route::prefix('skema')->group(function () {
            Route::get('datatable', [SkemaController::class, 'datatable'])->name('skema.datatable');
            Route::get('list',[SkemaController::class,'list'])->name('skema.list');
            Route::get('list/{uuid}', [SkemaController::class, 'listByUUID'])->name('skema.listByUuid');
        });
        // Unit Komptensi
        Route::resource('unit-kompetensi',UnitKompetensiController::class)->names('unitKompetensi')->except(['create', 'show']);
        Route::prefix('unit-kompetensi')->group(function () {
            Route::get('datatable', [UnitKompetensiController::class, 'datatable'])->name('unitKompetensi.datatable');
            Route::get('list',[UnitKompetensiController::class,'list'])->name('unitKompetensi.list');
            Route::get('list/{uuid}', [UnitKompetensiController::class, 'listByUUID'])->name('unitKompetensi.listByUuid');

        });
        // Elemen
        Route::resource('elemen',ElemenController::class)->except(['create', 'show']);
        Route::prefix('elemen')->group(function () {
            Route::get('datatable', [ElemenController::class, 'datatable'])->name('elemen.datatable');
            Route::get('list',[ElemenController::class,'list'])->name('elemen.list');
            Route::get('list/{uuid}', [ElemenController::class, 'listByUUID'])->name('elemen.listByUuid');
        });
        // Kriteria Unjuk Kerja
        Route::resource('kriteria-unjuk-kerja',KriteriaUnjukKerjaController::class)->names('kriteriaUnjukKerja')->except(['create', 'show']);
        Route::prefix('kriteria-unjuk-kerja')->group(function () {
            Route::get('datatable', [KriteriaUnjukKerjaController::class, 'datatable'])->name('kriteriaUnjukKerja.datatable');
            Route::get('list',[KriteriaUnjukKerjaController::class,'list'])->name('kriteriaUnjukKerja.list');
            Route::get('list/{uuid}', [KriteriaUnjukKerjaController::class, 'listByUUID'])->name('kriteriaUnjukKerja.listByUuid');
            Route::get('list-by-unit-kompetensi/{uuid}',[KriteriaUnjukKerjaController::class,'listByUnitKompetensi'])->name('kriteriaUnjukKerja.listByUnitKompetensi');
        });
        // Berkas Permohonan
        Route::resource('berkas-permohonan',BerkasPemohonController::class)->names('berkasPemohon')->except(['create', 'show']);
        Route::prefix('berkas-permohonan')->group(function () {
            Route::get('datatable', [BerkasPemohonController::class, 'datatable'])->name('berkasPemohon.datatable');
            Route::get('list',[BerkasPemohonController::class,'list'])->name('berkasPemohon.list');
            Route::get('list/{uuid}', [BerkasPemohonController::class, 'listByUUID'])->name('berkasPemohon.listByUuid');
        });
        // Ujian Tulis
        Route::resource('ujian-tulis',TestTulisController::class)->names('ujianTulis')->except(['create', 'show']);
        Route::prefix('ujian-tulis')->group(function () {
            Route::get('datatable', [TestTulisController::class, 'datatable'])->name('ujianTulis.datatable');
            Route::get('list',[TestTulisController::class,'list'])->name('ujianTulis.list');
            Route::get('list/{uuid}', [TestTulisController::class, 'listByUUID'])->name('ujianTulis.listByUuid');
        });
        // Ujian Praktek
        Route::resource('ujian-praktek',TestPraktekController::class)->names('ujianPraktek');
        // Ujian Wawancara
        Route::resource('ujian-wawancara',TestWawancaraController::class)->names('ujianWawancara')->except(['create', 'show']);
        Route::prefix('ujian-wawancara')->group(function () {
            Route::get('datatable', [TestWawancaraController::class, 'datatable'])->name('ujianWawancara.datatable');
        });
        // Jurusan
        Route::resource('jurusan',JurusanController::class)->except(['create', 'show']);
        Route::prefix('jurusan')->group(function () {
            Route::get('datatable', [JurusanController::class, 'datatable'])->name('jurusan.datatable');
            Route::get('list',[JurusanController::class,'list'])->name('jurusan.list');
        });
        // Kelas
        Route::resource('kelas',KelasController::class)->except(['create', 'show']);
        Route::prefix('kelas')->group(function () {
            Route::get('datatable', [KelasController::class, 'datatable'])->name('kelas.datatable');
            Route::get('list',[KelasController::class,'list'])->name('kelas.list');
        });
        // Asesor
        Route::resource('asesor',AsesorController::class)->except(['create', 'show']);
        Route::prefix('asesor')->group(function () {
            Route::get('datatable', [AsesorController::class, 'datatable'])->name('asesor.datatable');
            Route::get('list',[AsesorController::class,'list'])->name('asesor.list');
            Route::get('list/{uuid}', [AsesorController::class, 'listByUUID'])->name('asesor.listByUuid');
        });
        // Asesi
        Route::resource('asesi',AsesiController::class)->except(['create', 'show']);
        Route::prefix('asesi')->group(function () {
            Route::get('datatable', [AsesiController::class, 'datatable'])->name('asesi.datatable');
            Route::get('list',[AsesiController::class,'list'])->name('asesi.list');
        });
        // Route::get('sertifikasi', [SertifikasiController::class, 'index'])->name('sertifikasi.index');
        Route::resource('sertifikasi',CertificateController::class)->except(['index', 'create', 'show']);
        Route::prefix('sertifikasi')->group(function () {
            Route::get('', [CertificateController::class, 'index'])->name('sertifikasi.index');
            // Menggunakan metode POST dan melewatkan uuid sebagai parameter
            Route::post('sertifikasi/generate-certificate/{uuid}', [CertificateController::class, 'generateCertificate'])->name('sertifikasi.upload');
            Route::get('export-pdf', [CertificateController::class, 'exportPdf'])->name('export.pdf');
            Route::get('datatable', [CertificateController::class, 'datatable'])->name('sertifikasi.datatable');
        });
        // Pengaturan
        Route::prefix('pengaturan')->group(function () {
            Route::get('',[PengaturanConctroller::class,'index'])->name('pengaturan');
            Route::post('',[PengaturanConctroller::class,'store'])->name('pengaturan.store');
            Route::get('datatable', [PengaturanConctroller::class, 'datatable'])->name('pengaturan.datatable');
            Route::delete('delete-image/{type}',[PengaturanConctroller::class,'deleteImage'])->name('pengaturan.image-delete');
        });
        // TTD FRAPL01 & FRAPL02
        Route::post('frapl01-assesmen/admin-signature',[FRAPL01Controller::class,'adminSignature'])->name('frapl01.admin-signature');
    });

    // Asesi Middleware
    Route::middleware('can:asesi')->group(function() {
        Route::prefix('event-asesi')->group(function () {
            Route::get('{uuid}/datatable', [EventAsesiController::class, 'datatable'])->name('event-asesi.datatable');
            Route::get('{uuid}/show',[EventAsesiController::class,'show'])->name('event-asesi.show');
            // Route untuk download sertifikat
            Route::get('{uuid}/certificates/download/{id}', [EventAsesiController::class, 'downloadCertificate'])->name('certificates.download');
        });
        // TTD Test Wawancara
        Route::post('test-wawancara-assesmen/asesi-signature',[UserTestWawancaraController::class,'asesiSignature'])->name('userTestWawancara.asesi-signature');
        // TTD Checklist Observasi
        Route::post('checklist-observasi-assesmen/asesi-signature',[ObservasiController::class,'asesiSignature'])->name('checklistObservasi.asesi-signature');
    });

    // Asesor Middleware
    Route::middleware('can:asesor')->group(function() {
        Route::prefix('event-asesor')->group(function () {
            Route::get('{uuid}/datatable', [EventAsesorController::class, 'datatable'])->name('event-asesor.datatable');
            Route::get('{uuid}/show', [EventAsesorController::class, 'show'])->name('event-asesor.show');
            Route::post('{uuid}/update-qualification-status', [EventAsesorController::class, 'updateQualificationStatus']);
        });        
        // TTD Test Tulis & Praktek
        Route::post('test-tulis-assesmen/asesor-signature',[UserTestTulisController::class,'asesorSignature'])->name('userTestTulis.asesor-signature');
        Route::post('test-praktek-assesmen/asesor-signature',[UserTestPraktekController::class,'asesorSignature'])->name('userTestPraktek.asesor-signature');
        // TTD Persetujuan Assesmen
        Route::post('persetujuan-assesmen/asesor-signature',[PersetujuanKerahasiaanController::class,'asesorSignature'])->name('persetujuanAssesmen.asesor-signature');
        // TTD FRAPL02
        Route::post('frapl02-assesmen/asesor-signature',[FRAPL02Controller::class,'asesorSignature'])->name('frapl02.asesor-signature');
    });

    // All
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Persetujuan Assesmen
    Route::resource('persetujuan-assesmen',PersetujuanKerahasiaanController::class)->names('persetujuanAssesmen')->except(['create', 'show']);
    Route::prefix('persetujuan-assesmen')->group(function () {
        Route::get('datatable', [PersetujuanKerahasiaanController::class, 'datatable'])->name('persetujuanAssesmen.datatable');
        Route::get('show-by-kelompokAsesor',[PersetujuanKerahasiaanController::class,'showByKelompokAsesor'])->name('persetujuanAssesmen.show-by-kelompokAsesor');
        Route::get('list',[PersetujuanKerahasiaanController::class,'list'])->name('persetujuanAssesmen.list');
        Route::get('list-by-asesor/{uuid}', [PersetujuanKerahasiaanController::class, 'listByAsesorUUID'])->name('persetujuanAssesmen.listByAsesorUuid'); // Catatan Error
        Route::get('list-by-asesi/{uuid}', [PersetujuanKerahasiaanController::class, 'listByAsesiUUID'])->name('persetujuanAssesmen.listByAsesiUuid');
    });
    // Checklist Observasi
    Route::resource('checklist-observasi-assesmen',ObservasiController::class)->names('checklistObservasi')->except(['create', 'show','edit','update','destroy']);
    Route::prefix('checklist-observasi-assesmen')->group(function () {
        Route::get('show-by-kelompokAsesor',[ObservasiController::class,'showByKelompokAsesor'])->name('checklistObservasi.show-by-kelompokAsesor');
    });
    // FRAPL MAIN
    Route::get('frapl-assesmen',FRAPLcontroller::class)->name('frapl.index');
    // FRAPL01
    Route::resource('frapl01-assesmen',FRAPL01Controller::class)->names('frapl01')->except(['create', 'show']);
    Route::prefix('frapl01-assesmen')->group(function () {
        Route::get('show-by-kelompokAsesor',[FRAPL01Controller::class,'showByKelompokAsesor'])->name('frapl01.show-by-kelompokAsesor');
    });
    // FRAPL02
    Route::resource('frapl02-assesmen',FRAPL02Controller::class)->names('frapl02')->except(['create', 'show']);
    Route::prefix('frapl02-assesmen')->group(function () {
        Route::get('show-by-kelompokAsesor',[FRAPL02Controller::class,'showByKelompokAsesor'])->name('frapl02.show-by-kelompokAsesor');
    });

    // Test Assesmen MAIN
    Route::get('test-assesmen',TestAssesmenController::class)->name('testAssesmen.index');
    // Test Tulis User
    Route::resource('test-tulis-assesmen-asesi',UserTestTulisController::class)->names('userTestTulis')->except(['create','show','edit','update','destroy']);
    Route::prefix('test-tulis-assesmen')->group(function () {
        Route::get('show-by-kelompokAsesor',[UserTestTulisController::class,'showByKelompokAsesor'])->name('userTestTulis.show-by-kelompokAsesor');
    });
    // Test Praktek User
    Route::resource('test-praktek-assesmen-asesi',UserTestPraktekController::class)->names('userTestPraktek')->except(['create']);
    Route::prefix('test-praktek-assesmen')->group(function () {
        Route::get('show-by-kelompokAsesor',[UserTestPraktekController::class,'showByKelompokAsesor'])->name('userTestPraktek.show-by-kelompokAsesor');
    });
    // Test Wawancara
    Route::resource('test-wawancara-assesmen-asesi', UserTestWawancaraController::class)->names('userTestWawancara')->except(['create','show','edit','update','destroy']);
    Route::prefix('test-wawancara-assesmen-asesi')->group(function () {
        Route::get('show-by-kelompokAsesor',[UserTestWawancaraController::class,'showByKelompokAsesor'])->name('userTestWawancara.show-by-kelompokAsesor');
    });

});

require __DIR__.'/auth.php';
