@extends('layouts.app.main')
@section('title','Persetujuan Kerahasiaan')
@section('content')
    @php
        $basePrefixUrl = 'event-asesi.show';
        $asesiId = '';
        $kelompokAsesorId = '';
        $baseUrl = route('frapl.index', $kelompokAsesor['uuid']);

        if (Gate::allows('asesor') || Gate::allows('admin')) {
            $basePrefixUrl = 'event-asesor.show';
            $asesiId = request('asesi-id');
            $baseUrl = route('frapl.index', request('asesi-id'));
            $kelompokAsesorId = '&kelompok-asesor-id=' . $kelompokAsesor['uuid'];
        }
    @endphp
    <div class="row layout-top-spacing" id="cancel-row">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Event Saya
                        </a>
                        <div class="dropdown-menu right" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(105px, 0, 0px); top: 0px; left: 0px;">
                            @forelse($kelompokAsesorNotIn as $data)
                                <a class="dropdown-item" href="{{ $basePrefixUrl . $data['uuid'] }}">{{ $data->event['nama_event'] }}</a>
                            @empty
                                <a class="dropdown-item" href="javascript:void(0);">Tidak ada data</a>
                            @endforelse
                        </div>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ $baseUrl . $kelompokAsesorId }}">Daftar FRAPL Assesmen</a></li>
                    <li class="breadcrumb-item active" aria-current="page">PERMOHONAN SERTIFIKASI KOMPETENSI</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form class="needs-validation" id="form-berkas-frapl01" novalidate method="POST" action="{{ route('frapl01.store', ['kelompok-asesor-uuid' => $kelompokAsesor['uuid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="signatureAsesi" id="signatureAsesi" name="signatureAsesi">
                        <div id="example-basic">
                            <h3>Pemohon Sertifikasi</h3>
                            <section>
                                <div class="row mb-4">
                                    <h5 class="col-12 mb-3">a. Data Pribadi</h5>
                                    <p><span class="text-danger">*</span> Wajib diisi</p>
                                </div>
                                @if($isAsesi)
                                    <div class="form-group row mb-4">
                                        <label for="name" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                        <div class="col-xl-10 col-lg-9 col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                        </div>
                                    </div>   
                                    @endif                             
                                <div class="form-group row mb-4">
                                    <label for="no_ktp" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">No. KTP/NIK/Paspor<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" placeholder="Masukkan No. KTP/NIK/Paspor peserta" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="tempat_lahir" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Tempat Lahir<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir peserta" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="tgl_lahir" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Masukkan tanggal lahir peserta" required>
                                    </div>
                                </div>
                                @if($isAsesi)
                                    <fieldset class="form-group mb-4">
                                        <div class="row">
                                            <label class="col-form-label col-xl-2 col-sm-3 col-sm-2 pt-0">Jenis Kelamin<span class="text-danger">*</span></label>
                                            <div class="col-xl-10 col-lg-9 col-sm-10">
                                                <div class="form-check mb-2">
                                                    <div class="custom-control custom-radio classic-radio-info">
                                                        <input type="radio" id="jklakilaki" name="jenis_kelamin" value="Laki-laki" readonly class="custom-control-input" 
                                                        {{ $user->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="jklakilaki">Laki-laki</label>
                                                    </div>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <div class="custom-control custom-radio classic-radio-info">
                                                        <input type="radio" id="jkperempuan" name="jenis_kelamin" value="Perempuan" readonly class="custom-control-input" 
                                                        {{ $user->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for "jkperempuan">Perempuan</label>
                                                    </div>
                                                </div>
                                                @if(empty($user->jenis_kelamin))
                                                    <p class="badge bg-danger mt-2">Jenis Kelamin kosong. Harap lengkapi di menu <a class="text-white text-uppercase font-weight-bold" title="Profile Saya" href="{{ route('profile.index') }}">profile saya</a></p>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                @endif
                                <div class="form-group row mb-4">
                                    <label for="kebangsaan" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Kebangsaan<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="kebangsaan" name="kebangsaan" placeholder="Masukkan kebangsaan peserta" required>
                                    </div>
                                </div>
                                @if($isAsesi)
                                    <div class="form-group row mb-4">
                                        <label for="address" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Alamat Rumah<span class="text-danger">*</span></label>
                                        <div class="col-xl-10 col-lg-9 col-sm-10">
                                            <textarea class="form-control" id="address" cols="20" rows="5" name="address" readonly>{{ $user->address }}</textarea>
                                            @if(empty($user->address))
                                                <p class="badge bg-danger mt-2">Alamat Rumah kosong. Harap lengkapi di menu <a class="text-white text-uppercase font-weight-bold" title="Profile Saya" href="{{ route('profile.index') }}">profile saya</a></p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row mb-4">
                                    <label for="kode_pos" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Kode Pos Rumah<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="number" class="form-control" id="kode_pos" name="kode_pos" placeholder="Masukkan kode pos domisili peserta" required>
                                    </div>
                                </div>
                                @if($isAsesi)
                                <div class="form-group row mb-4">
                                    <label for="phone" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">No. Telp/HP/WA Peserta<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="number" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" readonly>
                                        @if(empty($user->phone))
                                            <p class="badge bg-danger mt-2">No. Telp kosong. Harap lengkapi di menu <a class="text-white text-uppercase font-weight-bold" title="Profile Saya" href="{{ route('profile.index') }}">profile saya</a></p>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row mb-4">
                                    <label for="tlp_rumah" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">No. Telp/HP/WA Rumah</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="number" class="form-control" id="tlp_rumah" name="tlp_rumah" placeholder="Masukkan No. Telp/HP/WA rumah (pilih salah satu opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="tlp_kantor" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">No. Telp/HP/WA Kantor</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="number" class="form-control" id="tlp_kantor" name="tlp_kantor" placeholder="Masukkan No. Telp/HP/WA kantor (pilih salah satu opsional)">
                                    </div>
                                </div>
                                @if($isAsesi)
                                    <div class="form-group row mb-4">
                                        <label for="email" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Email Peserta<span class="text-danger">*</span></label>
                                        <div class="col-xl-10 col-lg-9 col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                @endif                              
                                <div class="form-group row mb-4">
                                    <label for="pendidikan" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Pendidikan Terakhir<span class="text-danger">*</span></label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Masukkan kualifikasi pendidikan terakhir peserta (D3/D4)" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <h5 class="col-12 mb-3">b. Data Pekerjaan Sekarang</h5>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="nama_institusi" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Nama Institusi</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="nama_institusi" name="nama_institusi" placeholder="Masukkan nama institusi (opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="jabatan" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Jabatan</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan terakhir (opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="no_tlp_institusi" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">No. Telp/HP/WA Institusi</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="number" class="form-control" id="no_tlp_institusi" name="no_tlp_institusi" placeholder="Masukkan No. Telp/HP/WA institusi (pilih salah satu opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="kode_pos_institusi" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Kode Pos Institusi</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="number" class="form-control" id="kode_pos_institusi" name="kode_pos_institusi" placeholder="Masukkan kode pos institusi (opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="email_institusi" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Email Institusi</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="email" class="form-control" id="email_institusi" name="email_institusi" placeholder="Masukkan email institusi (opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="fax" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">FAX Institusi</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <input type="text" class="form-control" id="fax" name="fax" placeholder="Masukkan fax institusi (opsional)">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="alamat_kantor" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Alamat Kantor</label>
                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                        <textarea class="form-control" name="alamat_kantor" id="alamat_kantor" cols="20" rows="5" placeholder="Masukkan kantor peserta (opsional)"></textarea>
                                    </div>
                                </div>
                            </section>
                            <h3>Data Sertifikasi</h3>
                            <section>
                                <table class="table table-borderless" style="background-color: #ebf3fe; border-radius: 5px;">
                                    <tbody>
                                        <tr style="border: none !important;">
                                            <th>Skema Sertifikasi</th>
                                            <td>:</td>
                                            <td>{{ $kelompokAsesor->skema['jenis_standar'] }}</td>
                                        </tr>
                                        <tr style="border: none !important;">
                                            <th>Nomor Skema</th>
                                            <td>:</td>
                                            <td>{{ $kelompokAsesor->skema['no_skema'] }}</td>
                                        </tr>
                                        <tr style="border: none !important;">
                                            <th>Judul Skema</th>
                                            <td>:</td>
                                            <td>{{ $kelompokAsesor->skema['judul_skema'] }}</td>
                                        </tr>
                                        <tr style="border: none !important;">
                                            <th>TUK</th>
                                            <td>:</td>
                                            <td>{{ $kelompokAsesor->event['tuk'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr style="border: none !important;">
                                            <th>Tujuan Assesmen</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex">
                                    <div class="ml-3">
                                        <div class="n-chk">
                                            <label class="new-control new-radio new-radio-text radio-classic-success">
                                            <input type="radio" class="new-control-input" name="tujuan_assesmen" id="ckSertifikasi" value="Sertifikasi">
                                            <span class="new-control-indicator"></span><span class="new-radio-content">Sertifikasi</span>
                                            </label>
                                        </div>
                                        <div class="n-chk">
                                            <label class="new-control new-radio new-radio-text radio-classic-success">
                                            <input type="radio" class="new-control-input" name="tujuan_assesmen" id="ckSertifikasiulang" value="Sertifikasi Ulang">
                                            <span class="new-control-indicator"></span><span class="new-radio-content">Sertifikasi Ulang</span>
                                            </label>
                                        </div>
                                        <div class="n-chk">
                                            <label class="new-control new-radio new-radio-text radio-classic-success">
                                            <input type="radio" class="new-control-input" name="tujuan_assesmen" id="ckPKT" value="Pengakuan Kompetensi Terkini (PKT)">
                                            <span class="new-control-indicator"></span><span class="new-radio-content">Pengakuan Kompetensi Terkini (PKT)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="ml-5">
                                        <div class="n-chk">
                                            <label class="new-control new-radio new-radio-text radio-classic-success">
                                            <input type="radio" class="new-control-input" name="tujuan_assesmen" id="ckRPL" value="Rekognisi Pembelajaran Lampau">
                                            <span class="new-control-indicator"></span><span class="new-radio-content">Rekognisi Pembelajaran Lampau</span>
                                            </label>
                                        </div>
                                        <div class="n-chk">
                                            <label class="new-control new-radio new-radio-text radio-classic-success">
                                            <input type="radio" class="new-control-input" name="tujuan_assesmen" id="ckLainnya" value="Lainnya">
                                            <span class="new-control-indicator"></span><span class="new-radio-content">Lainnya</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr style="border: none !important;">
                                            <th>Daftar Unit Kompetensi Sesuai Kemasan</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="table-responsive" style="height: 250px; overflow-y: auto;">
                                    <table class="table table-borderless">
                                        <thead>
                                            <th class="text-center" scope="col">No</th>
                                            <th class="text-center" scope="col">Kode Unit</th>
                                            <th class="text-center" scope="col">Judul Unit</th>
                                            <th class="text-center" scope="col">Jenis Standar (Standar Khusus/ StandarInternasional/ SKKNI)</th>
                                        </thead>
                                        <tbody>
                                            @forelse($kelompokAsesor->skema->unitKompetensi as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data['kode_unit'] }}</td>
                                                    <td>{{ $data['judul_unit'] }}</td>
                                                    <td class="text-center">{{ $data['jenis_standar'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">Data Unit Kompetensi Tidak Tersedia</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <h3>Bukti Kelengkapan Pemohon</h3>
                            <section>
                                <div class="row mb-4">
                                    <h5 class="col-12 mb-3">Bukti Persyaratan Dasar Pemohon</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <th class="text-center" scope="col">No</th>
                                            <th class="text-center" scope="col">Bukti Persyaratan Dasar</th>
                                            <th class="text-center" scope="col">Jawaban</th>
                                            <th class="text-center" scope="col">File</th>
                                        </thead>
                                        <tbody>
                                            @forelse($kelompokAsesor->skema->berkasPermohonan as $index => $data)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $data['nama_berkas'] }}</td>
                                                    <td>
                                                        <div class="n-chk">
                                                            <label class="new-control new-radio new-radio-text radio-classic-success">
                                                                <input type="radio" class="new-control-input" id="statusBerkasPemohon_{{ $index }}"name="statusBerkasPemohon[{{ $index }}]" value="Memenuhi Syarat">
                                                                <span class="new-control-indicator"></span><span class="new-radio-content">Memenuhi Syarat</span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk">
                                                            <label class="new-control new-radio new-radio-text radio-classic-warning">
                                                                <input type="radio" class="new-control-input" name="statusBerkasPemohon[{{ $index }}]" value="Tidak Memenuhi Syarat">
                                                                <span class="new-control-indicator"></span><span class="new-radio-content">Tidak Memenuhi Syarat</span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk">
                                                            <label class="new-control new-radio new-radio-text radio-classic-danger">
                                                                <input type="radio" class="new-control-input" name="statusBerkasPemohon[{{ $index }}]" value="Tidak Ada">
                                                                <span class="new-control-indicator"></span><span class="new-radio-content">Tidak Ada</span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-file mb-4">
                                                            <input type="file" class="custom-file-input" id="berkasFilePemohon_{{ $index }}" name="berkasFilePemohon[{{ $index }}]" accept=".pdf">
                                                            <label class="custom-file-label" for="berkasFilePemohon_{{ $index }}">Choose file</label>
                                                        </div>
                                                        <p><small>Available format: .PDF Max: 2MB <span id="uploadStatus_{{ $index }}" class="text-danger"> (Belum Upload)</span> </small></p>
                                                        <p>File: <a href="" class="text-primary d-none" style="text-decoration: underline;" target="__blank" id="fileLink_{{ $index }}">Tampilkan file</a></p>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">Data Berkas Tidak Tersedia</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @can('admin')
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr style="border: none !important;">
                                                <th>Catatan Admin LSP</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group row mb-4">
                                        <div class="col-12">
                                            <textarea class="form-control" name="catatan" id="catatan" cols="20" rows="5" placeholder="Masukkan catatan (opsional)"></textarea>
                                        </div>
                                    </div>
                                @endcan
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr style="border: none !important;">
                                                <th>Tanda Tangan Berkas</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex mb-3">
                                        <div class="ttd-asesi text-center">
                                            <div style="margin-left:12px; border: 1px solid black; width: 130px; height: 60px;">
                                                <div id="available-ttdAsesi"></div>
                                            </div>
                                            <br>
                                            @can('asesi')
                                                <span class="btn btn-sm btn-outline-primary" id="modal-ttdAsesi" data-toggle="modal" data-target="#create-ttd-asesi"> Tanda Tangan Asesi</span>
                                            @else
                                                <span class="text-primary ml-2" id="date-ttdAsesi"></span>
                                            @endcan
                                        </div>
                                        <div class="ttd-asesor text-center ml-5">
                                            <div style="margin-left:27px; border: 1px solid black; width: 130px; height: 60px;">
                                                <div id="available-ttdAdminLSP"></div>
                                            </div>
                                            <br>
                                            @can('admin')
                                                <span class="ml-1 btn btn-sm btn-outline-primary" id="modal-ttdAdminLSP" data-toggle="modal" data-target="#create-ttd-adminLSP"> Tanda Tangan Admin LSP</span>
                                            @else
                                            <span class="text-primary ml-2" id="date-ttdAdminLSP"></span>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.frapl.frapl01.scriptComponent')
@endsection
