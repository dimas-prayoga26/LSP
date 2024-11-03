@extends('layouts.app.main')
@section('title','Daftar FRAPL Assesmen')
@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Event Saya
                        </a>
                        @php
                            $basePrefixUrl = 'event-asesi.show';
                        @endphp
                        @can('asesor')
                            @php
                                $basePrefixUrl = 'event-asesor.show';
                            @endphp
                        @endcan
                        <div class="dropdown-menu right" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(105px, 0, 0px); top: 0px; left: 0px;">
                            @forelse($kelompokAsesorNotIn as $data)
                                <a class="dropdown-item" href="{{ route($basePrefixUrl, $data['uuid']) }}">{{ $data->event['nama_event'] }}</a>
                            @empty
                                <a class="dropdown-item" href="javascript:void(0);">Tidak ada data</a>
                            @endforelse
                        </div>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Test Assesmen</li>
                </ol>
            </nav>
        </div>
        @php
            // Ttd Asesi Check Test Tulis
            $queryTestTulisAsesi = $kelompokAsesor->userTestTulis
                ->where('asesi_id', $asesiId)
                ->where('kelompok_asesor_id',$kelompokAsesor['id']);
            $is_testTulisTtdAsesor = (clone $queryTestTulisAsesi)->where('ttd_asesor','!=', null)->first();
            $is_testTulisTtdAsesi = $queryTestTulisAsesi->where('ttd_asesi','!=', null)->first();
            // Ttd Check Test Praktek
            $queryTestPraktekAsesor = $kelompokAsesor->userTestPraktek
                ->where('asesi_id', $asesiId)
                ->where('kelompok_asesor_id',$kelompokAsesor['id']);
            $is_testPraktekTtdAsesor = (clone $queryTestPraktekAsesor)->where('ttd_asesor','!=', null)->first();
            $is_testPraktekTtdAsesi = $queryTestPraktekAsesor->where('ttd_asesi','!=', null)->first();
            // Ttd Check Test Wawancara
            $queryTestWawancaraAsesor = $kelompokAsesor->userTestWawancara
                ->where('asesi_id',$asesiId)
                ->where('kelompok_asesor_id',$kelompokAsesor['id']);
            $is_testWawancaraTtdAsesor = (clone $queryTestWawancaraAsesor)->where('ttd_asesor','!=', null)->first();
            $is_testWawancaraTtdAsesi = $queryTestWawancaraAsesor->where('ttd_asesi','!=', null)->first();

            $eventMulai = Carbon\Carbon::parse($kelompokAsesor->event['event_mulai']);
            $eventSelesai = Carbon\Carbon::parse($kelompokAsesor->event['event_selesai']);
            $rangeWaktuEvent = $eventSelesai->diffForHumans(['parts' => 3, 'join' => true, 'short' => true, 'syntax' => Carbon\Carbon::DIFF_ABSOLUTE]);

            $asesiId = '';
            $baseUrlTestTulis = route('userTestTulis.index', $kelompokAsesor['uuid']);
            $baseUrlTestPraktek = route('userTestPraktek.index', [$kelompokAsesor['uuid']]);
            $baseUrlTestWawancara = route('userTestWawancara.index', [$kelompokAsesor['uuid']]);

            $image = 'admin/assets/img/nopict.png';
            if($asesiPhoto != null && Storage::exists($asesiPhoto)) {
                $image = 'storage/'. $asesiPhoto;
            }
            if (Gate::allows('asesor')) {
                $asesiId = '&asesi-id=' . request()->query->keys()[0];
            }
        @endphp
        {{-- Test Tulis --}}
        {{-- <div class="col-12 mb-3">
            <div class="widget widget-account-invoice-three">
                <div class="widget-heading">
                    <div class="wallet-usr-info">
                        <div class="usr-name">
                            <span><img src="{{ asset($image) }}" alt="admin-profile" class="img-fluid"> {{ $asesiName }}</span>
                        </div>
                        <div class="add">
                            <span title="Kerjakan Soal Test Tulis" onclick="window.location.href='{{ $baseUrlTestTulis . $asesiId }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </span>
                        </div>
                    </div>
                    <div class="wallet-balance">
                        <p>Test Tulis</p>
                    </div>
                </div>
                <div class="widget-amount">
                    <div class="w-a-info funds-received">
                        <span>Pelaksanaan</span>
                        <p>
                            {{ $eventMulai->isoFormat('dddd, DD MMMM Y') }}
                            {{ $eventMulai->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>
                    <div class="w-a-info funds-spent">
                        <span>Selesai</span>
                        <p>
                            {{ $eventSelesai->isoFormat('dddd, DD MMMM Y') }}
                            {{ $eventSelesai->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <span @class(['text-wrap','badge','p1',
                                'bg-success' => $is_testTulisTtdAsesi,
                                'bg-danger' => !$is_testTulisTtdAsesi,
                                ])> {{ $is_testTulisTtdAsesi ? 'Ditandatangani oleh Asesi' : 'Belum Ditandatangani Asesi' }}
                            </span>
                        </div>
                        <div>
                            <span @class(['text-wrap','badge','p1',
                                'bg-success' => $is_testTulisTtdAsesor,
                                'bg-danger' => !$is_testTulisTtdAsesor,
                                ])> {{ $is_testTulisTtdAsesor ? 'Ditandatangani oleh Asesor' : 'Belum Ditandatangani Asesor' }}
                            </span>
                        </div>
                    </div>
                    <div class="invoice-list">
                        <div class="inv-detail">
                            <div class="info-detail-1">
                                <p>Jenis Soal</p>
                                <p><span class="bill-amount">Pilihan Ganda</span></p>
                            </div>
                            <div class="info-detail-2">
                                <p>Jumlah Soal</p>
                                <p><span class="bill-amount">{{ $testTulisCount }} Soal</span></p>
                            </div>
                            <div class="info-detail-3">
                                <p>Siswa Waktu Pengerjaan</p>
                                <p><span class="bill-amount">{{ $rangeWaktuEvent }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- Test Praktik --}}
        {{-- <div class="col-12">
            <div class="widget widget-account-invoice-three">
                <div class="widget-heading">
                    <div class="wallet-usr-info">
                        <div class="usr-name">
                            <span><img src="{{ asset($image) }}" alt="admin-profile" class="img-fluid"> {{ $asesiName }}</span>
                        </div>
                        <div class="add">
                            <span title="Kerjakan Soal Test Praktek" onclick="window.location.href='{{ $baseUrlTestPraktek . $asesiId }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </span>
                        </div>
                    </div>
                    <div class="wallet-balance">
                        <p>Test Praktek</p>
                    </div>
                </div>
                <div class="widget-amount">
                    <div class="w-a-info funds-received">
                        <span>Pelaksanaan</span>
                        <p>
                            {{ $eventMulai->isoFormat('dddd, DD MMMM Y') }}
                            {{ $eventMulai->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>
                    <div class="w-a-info funds-spent">
                        <span>Selesai</span>
                        <p>
                            {{ $eventSelesai->isoFormat('dddd, DD MMMM Y') }}
                            {{ $eventSelesai->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <span @class(['badge','p1',
                                'bg-success' => $is_testPraktekTtdAsesi,
                                'bg-danger' => !$is_testPraktekTtdAsesi,
                                ])> {{ $is_testPraktekTtdAsesi ? 'Ditandatangani oleh Asesi' : 'Belum Ditandatangani Asesi' }}
                            </span>
                        </div>
                        <div>
                            <span @class(['badge','p1',
                                'bg-success' => $is_testPraktekTtdAsesor,
                                'bg-danger' => !$is_testPraktekTtdAsesor,
                                ])> {{ $is_testPraktekTtdAsesor ? 'Ditandatangani oleh Asesor' : 'Belum Ditandatangani Asesor' }}
                            </span>
                        </div>
                    </div>
                    <div class="invoice-list">
                        <div class="inv-detail">
                            <div class="info-detail-1">
                                <p>Jenis Soal</p>
                                <p><span class="bill-amount">Upload Dokumen/Teori/Materi</span></p>
                            </div>
                            <div class="info-detail-2">
                                <p>Jumlah Soal</p>
                                <p><span class="bill-amount">{{ $testPraktikCount }} Soal</span></p>
                            </div>
                            <div class="info-detail-3">
                                <p>Siswa Waktu Pengerjaan</p>
                                <p><span class="bill-amount">{{ $rangeWaktuEvent }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- Test Wawancara --}}
        <div class="col-12">
            <div class="widget widget-account-invoice-three">
                <div class="widget-heading">
                    <div class="wallet-usr-info">
                        <div class="usr-name">
                            <span><img src="{{ asset($image) }}" alt="admin-profile" class="img-fluid"> {{ $asesiName }}</span>
                        </div>
                        <div class="add">
                            <span title="Kerjakan Soal Test Wawancara" onclick="window.location.href='{{ $baseUrlTestWawancara . $asesiId }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </span>
                        </div>
                    </div>
                    <div class="wallet-balance">
                        <p>Test Wawancara</p>
                    </div>
                </div>
                <div class="widget-amount">
                    <div class="w-a-info funds-received">
                        <span>Pelaksanaan</span>
                        <p>
                            {{ $eventMulai->isoFormat('dddd, DD MMMM Y') }}
                            {{ $eventMulai->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>
                    <div class="w-a-info funds-spent">
                        <span>Selesai</span>
                        <p>
                            {{ $eventSelesai->isoFormat('dddd, DD MMMM Y') }}
                            {{ $eventSelesai->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <span @class(['badge','p1',
                                'bg-success' => $is_testWawancaraTtdAsesi,
                                'bg-danger' => !$is_testWawancaraTtdAsesi,
                                ])> {{ $is_testWawancaraTtdAsesi ? 'Ditandatangani oleh Asesi' : 'Belum Ditandatangani Asesi' }}
                            </span>
                        </div>
                        <div>
                            <span @class(['badge','p1',
                                'bg-success' => $is_testWawancaraTtdAsesor,
                                'bg-danger' => !$is_testWawancaraTtdAsesor,
                                ])> {{ $is_testWawancaraTtdAsesor ? 'Ditandatangani oleh Asesor' : 'Belum Ditandatangani Asesor' }}
                            </span>
                        </div>
                    </div>
                    <div class="invoice-list">
                        <div class="inv-detail">
                            <div class="info-detail-1">
                                <p>Jenis Soal</p>
                                <p><span class="bill-amount">Teori/Materi</span></p>
                            </div>
                            <div class="info-detail-2">
                                <p>Jumlah Soal</p>
                                <p><span class="bill-amount">{{ $testPraktikCount }} Soal</span></p>
                            </div>
                            <div class="info-detail-3">
                                <p>Siswa Waktu Pengerjaan</p>
                                <p><span class="bill-amount">{{ $rangeWaktuEvent }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
