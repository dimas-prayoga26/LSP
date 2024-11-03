@extends('layouts.app.main')
@section('title','Persetujuan Kerahasiaan')
@section('content')
    @php
        $asesiId = '';
        $basePrefixUrl = 'event-asesi.show';

        if (Gate::allows('asesor')) {
            $asesiId = request()->query->keys()[0];
            $basePrefixUrl = 'event-asesor.show';
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
                                <a class="dropdown-item" href="{{ route($basePrefixUrl, $data['uuid']) }}">{{ $data->event['nama_event'] }}</a>
                            @empty
                                <a class="dropdown-item" href="javascript:void(0);">Tidak ada data</a>
                            @endforelse
                        </div>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Lembar Persetujuan Kerahasiaan</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>PERSETUJUAN ASESMEN DAN KERAHASIAAN</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive" style="background-color: #ebf3fe; border-radius: 5px;">
                        <table class="table table-borderless">
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
                                <tr style="border: none !important;">
                                    <th>Pelaksanaan Assesmen</th>
                                </tr>
                                <tr style="border: none !important;">
                                    <td>Hari/Tanggal</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($kelompokAsesor->event['event_mulai'])->isoFormat('dddd, DD MMMM Y') }}</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($kelompokAsesor->event['event_mulai'])->isoFormat('HH:mm') }} WIB</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <td>TUK</td>
                                    <td>:</td>
                                    <td>{{ $kelompokAsesor->event['tuk'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr style="border: none !important;">
                                    <th>Bukti Kelengkapan</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form class="needs-validation" id="form-berkas-persetujuan" novalidate method="POST" action="{{ route('persetujuanAssesmen.store', ['uuid' => $kelompokAsesor['uuid']]) }}">
                        @csrf
                        <input type="hidden" name="signatureAsesi" id="signatureAsesi" name="signatureAsesi">
                        <div class="d-flex">
                            <div class="ml-3">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="ckportofolio" name="berkas[1]ckPortofolio" value="TL : Verifikasi Portofolio">
                                    <label style="cursor:pointer" class="custom-control-label" for="ckportofolio">TL : Verifikasi Portofolio</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="ckoberservasi" name="berkas[2]observasi" value="L : Observasi">
                                    <label style="cursor:pointer" class="custom-control-label" for="ckoberservasi">L : Observasi</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="cktestTulis" name="berkas[3]testTulis" value="T: Hasil Tes Tulis">
                                    <label style="cursor:pointer" class="custom-control-label" for="cktestTulis">T: Hasil Tes Tulis</label>
                                </div>
                            </div>
                            <div class="ml-5">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="cktestLisan" name="berkas[4]testLisan" value="T: Hasil Tes Lisan">
                                    <label style="cursor:pointer" class="custom-control-label" for="cktestLisan">T: Hasil Tes Lisan</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="cktestWawancara" name="berkas[5]testWawancara" value="T: Hasil Tes Wawancara">
                                    <label style="cursor:pointer" class="custom-control-label" for="cktestWawancara">T: Hasil Tes Wawancara</label>
                                </div>
                            </div>
                        </div>
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
                                    <div style="margin-left:17px; border: 1px solid black; width: 130px; height: 60px;">
                                        <div id="available-ttdAsesor"></div>
                                    </div>
                                    <br>
                                    @can('asesor')
                                        <span class="ml-1 btn btn-sm btn-outline-primary" id="modal-ttdAsesor" data-toggle="modal" data-target="#create-ttd-asesor"> Tanda Tangan Asesor</span>
                                    @else
                                        <span class="text-primary ml-2" id="date-ttdAsesor"></span>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        @can('asesi')
                            <button class="btn btn-primary mt-3" id="btn-form" type="submit">Simpan</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.lembarPersetujuanAsesi.scriptComponent')
@endsection
