@extends('layouts.app.main')
@section('title','Persetujuan Kerahasiaan')
@section('content')
    @php
        $asesiId = '';
        $basePrefixUrl = 'event-asesi.show';

        if (Gate::allows('asesor')  || Gate::allows('admin')) {
            $asesiId = request()->query->keys()[0];
            $basePrefixUrl = 'event-asesor.show';
        } elseif (Gate::allows('asesi')) {
            $asesiId = Auth::user()->asesi['uuid'];
            $basePrefixUrl = 'event-asesi.show';
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
                    <li class="breadcrumb-item active" aria-current="page">Lembar Checklist Observasi</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>Checklist Observasi Dan Aktivitas Kerja</h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mb-3" style="background-color: #ebf3fe; border-radius: 5px;">
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
                <div class="widget-content widget-content-area">
                    <form class="needs-validation" id="form-berkas-persetujuan" novalidate method="POST" action="{{ route('checklistObservasi.store', ['uuid' => $kelompokAsesor['uuid'],'asesi-id' => request()->query->keys()[0]]) }}">
                        @csrf
                        <input type="hidden" name="signatureAsesor" id="signatureAsesor" name="signatureAsesor">
                        @php
                            foreach($kelompokAsesor->skema->unitKompetensi as $unitKom) {
                                $groupedUnitKompetensi[$unitKom['judul_unit']][] = $unitKom;
                            }
                            $loopCount = 0;
                        @endphp
                        <div id="circle-basic">
                            @isset($groupedUnitKompetensi)
                                @forelse($groupedUnitKompetensi as $unitKom => $data)
                                    @forelse($data as $val)
                                        @foreach($val->elemen as $index => $elemen)
                                            @php($loopCount++)
                                            <h3>Elemen Ke-{{ $loopCount }}</h3>
                                            <section style="background-color: #fff;">
                                                <div class="form-row">
                                                    <div class="col-12 mb-3">
                                                        <label for="benchmark[{{ $val['id'] }}][{{ $elemen['id'] }}]">Benchmark</label>
                                                        <textarea class="form-control" name="benchmark[{{ $val['id'] }}][{{ $elemen['id'] }}]" id="benchmark[{{ $val['id'] }}][{{ $elemen['id'] }}]" rows="8"></textarea>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        @forelse($elemen->kriteriaUnjukKerja as $kuk)
                                                            <label for="">
                                                                {{ $kuk['nama_kriteria_kerja'] }}
                                                            </label>
                                                            <div>
                                                                <div class="n-chk">
                                                                    <label class="new-control new-radio new-radio-text radio-classic-success">
                                                                        <input type="radio" class="new-control-input" name="status_observasi[{{ $val['id'] }}][{{ $elemen['id'] }}][{{ $kuk['id'] }}]" value="Kompeten">
                                                                        <span class="new-control-indicator"></span><span class="new-radio-content">Kompeten (K)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="n-chk">
                                                                    <label class="new-control new-radio new-radio-text radio-classic-danger">
                                                                        <input type="radio" class="new-control-input" name="status_observasi[{{ $val['id'] }}][{{ $elemen['id'] }}][{{ $kuk['id'] }}]" value="Belum Kompeten">
                                                                        <span class="new-control-indicator"></span><span class="new-radio-content">Belum Kompeten (BK)</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <textarea name="penilaian_lanjut[{{ $val['id'] }}][{{ $elemen['id'] }}][{{ $kuk['id'] }}]" class="form-control mb-3" id="penilaian_lanjut[{{ $val['id'] }}][{{ $elemen['id'] }}][{{ $kuk['id'] }}]" cols="30" rows="3" placeholder="Penilaian Lanjut"></textarea>
                                                        @empty
                                                            <p class="text-danger">Daftar kriteria unjuk kerja tidak tersedia pada elemen ini</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </section>
                                        @endforeach
                                    @empty
                                        <p class="text-danger">Daftar unit kompetensi tidak tersedia</p>
                                    @endforelse
                                @empty
                                    <p class="text-danger">Data berkas Tidak Tersedia</p>
                                @endforelse
                            @else
                                <p class="text-danger">Data unit kompetensi Tidak Tersedia</p>
                            @endisset
                            <div class="table-responsive" style="background-color: #fff; border-top: 1px solid #000">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr style="border: none !important;">
                                            <th>Umpan Balik</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-12 mb-4">
                                    <textarea name="umpan_balik" class="form-control mb-3" id="umpan_balik" cols="30" rows="3" placeholder="Umpan balik untuk asesi"></textarea>
                                </div>
                            </div>
                            <div class="table-responsive" style="background-color: #fff;">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.checklistObservasiAsesi.scriptComponent')
@endsection
