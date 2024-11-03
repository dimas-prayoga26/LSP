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
                                <a class="dropdown-item" href="{{ route($basePrefixUrl, $data['uuid']) }}">{{ $data->event['nama_event'] }}</a>
                            @empty
                                <a class="dropdown-item" href="javascript:void(0);">Tidak ada data</a>
                            @endforelse
                        </div>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ $baseUrl . $kelompokAsesorId }}">Daftar FRAPL Assesmen</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ASSESMEN MANDIRI</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="">
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
                    <div class="row mb-4">
                        <h5 class="col-12 mb-3">ASSESMEN MANDIRI</h5>
                    </div>
                    <form class="needs-validation" id="form-berkas-frapl01" novalidate method="POST" action="{{ route('frapl02.store', ['kelompok-asesor-uuid' => $kelompokAsesor['uuid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="signatureAsesi" id="signatureAsesi" name="signatureAsesi">
                        <section style="height: 170vh; overflow-y: auto;">
                            @php
                                foreach($kelompokAsesor->skema->unitKompetensi as $unitKom) {
                                    $groupedUnitKompetensi[$unitKom['judul_unit']][] = $unitKom;
                                }
                            @endphp
                            <table class="table table-borderless">
                                <tbody>
                                    @isset($groupedUnitKompetensi)
                                        @forelse($groupedUnitKompetensi as $unitKom => $data)
                                            <tr style="border: none !important;">
                                                @php
                                                    $kodeUnit = '';
                                                    foreach($data as $val) {
                                                        if($val['judul_unit'] === $unitKom) {
                                                            $kodeUnit = $val['kode_unit'];
                                                        }
                                                    }
                                                @endphp
                                                <th>{{ 'Unit Kompetensi : [' . $kodeUnit . '] ' . $unitKom }}</th>
                                            </tr>
                                            <tr>
                                                <th>Daftar Elemen</th>
                                            </tr>
                                            @forelse($data as $val)
                                                @forelse($val->elemen as $elemen)
                                                    <tr>
                                                        <td>
                                                            <p class="text-wrap">{{ $elemen['nama_elemen'] }}</p>
                                                        </td>
                                                        <td>
                                                            <div class="n-chk">
                                                                <label class="new-control new-radio new-radio-text radio-classic-success">
                                                                    <input type="radio" class="new-control-input" name="statusAssesmenMandiri[{{ $elemen['id'] }}]" value="Kompeten">
                                                                    <span class="new-control-indicator"></span><span class="new-radio-content">Kompeten (K)</span>
                                                                </label>
                                                            </div>
                                                            <div class="n-chk">
                                                                <label class="new-control new-radio new-radio-text radio-classic-danger">
                                                                    <input type="radio" class="new-control-input" name="statusAssesmenMandiri[{{ $elemen['id'] }}]" value="Belum Kompeten">
                                                                    <span class="new-control-indicator"></span><span class="new-radio-content">Belum Kompeten (BK)</span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" id="berkasFilePemohon_{{ $elemen['id'] }}" name="berkasFilePemohon[{{ $elemen['id'] }}]" accept=".pdf">
                                                                <label class="custom-file-label" for="berkasFilePemohon_{{ $elemen['id'] }}">Choose file</label>
                                                            </div>
                                                            <p><small>Available format: .PDF Max: 2MB <span id="uploadStatus_{{ $elemen['id'] }}" class="text-danger"> (Belum Upload)</span> </small></p>
                                                            <p>File: <a href="" class="text-primary d-none" style="text-decoration: underline;" target="__blank" id="fileLink_{{ $elemen['id'] }}">Tampilkan file</a></p>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-danger">Daftar elemen tidak tersedia pada unit kompetensi ini</td>
                                                    </tr>
                                                @endforelse
                                            @empty
                                                <tr>
                                                    <td class="text-danger">Daftar unit kompetensi tidak tersedia</td>
                                                </tr>
                                            @endforelse
                                        @empty
                                            <tr>
                                                <td colspan="4">Data berkas Tidak Tersedia</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4">Data unit kompetensi Tidak Tersedia</td>
                                        </tr>
                                    @endisset
                                </tbody>
                            </table>
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
                            @can('asesi')
                                <button class="btn btn-primary mt-3 text-center" id="btn-form" type="submit">Simpan</button>
                            @endcan
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.frapl.frapl02.scriptComponent')
@endsection
