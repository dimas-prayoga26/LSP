@extends('layouts.app.main')
@section('title','Test Praktek Assesmen')
@section('content')
    @php
        $asesiId = '';
        $basePrefixUrl = 'event-asesi.show';

        if (Gate::allows('asesor')) {
            $asesiId = request('asesi-id');
        }
    @endphp
    @can('asesor')
        @php
            $basePrefixUrl = 'event-asesor.show';
        @endphp
    @endcan
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
                    @php
                        $kelompokAsesorId = '';
                        $baseUrl = route('testAssesmen.index', $kelompokAsesor['uuid']);
                    @endphp
                    @can('asesor')
                        @php
                            $baseUrl = route('testAssesmen.index', request('asesi-id'));
                            $kelompokAsesorId = '&kelompok-asesor-id=' . $kelompokAsesor['uuid'];
                        @endphp
                    @endcan
                    <li class="breadcrumb-item"><a href="{{ $baseUrl . $kelompokAsesorId }}">Daftar Test Assesmen</a></li>
                    <li class="breadcrumb-item active" aria-current="page">TUGAS PRAKTEK</li>
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
                    <form class="needs-validation" id="form-berkas-frapl01" novalidate method="POST" action="{{ route('userTestPraktek.store', ['kelompok-asesor-uuid' => $kelompokAsesor['uuid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="signatureAsesi" id="signatureAsesi" name="signatureAsesi">
                        <section style="height: 170vh; overflow-y: auto;">
                            <p style="height: 60vh; overflow-y: auto;">
                                {!! $kelompokAsesor->skema->testPraktek['isi_prosedur_kerja'] !!}
                            </p>
                            <div class="col-12 mb-2">
                                <label for="jawaban">Jawaban <span class="text-danger">*</span></label>
                                <div class="widget-content widget-content-area">
                                    <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban"></textarea>
                                </div>
                                <div class="invalid-feedback">
                                    Kolom jawaban tidak boleh kosong
                                </div>
                            </div>
                            <div class="custom-file-container" data-upload-id="mySecondImage">
                                <label>Upload (Allow Multiple) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                <label class="custom-file-container__custom-file" >
                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" multiple name="file[]">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                </label>
                                <div class="custom-file-container__image-preview"></div>
                            </div>
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
    @include('dashboard.testAssesmen.testPraktek.scriptComponent')
    @push('ckEditor')
        <script>
            ClassicEditor
                .create(document.querySelector('#jawaban'), {
                    toolbar: {
                        items: [
                            'exportPDF','exportWord', '|',
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            '-',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            'alignment', '|',
                            'link', 'blockQuote', 'insertTable', 'codeBlock', 'htmlEmbed', '|',
                            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                            'textPartLanguage', '|',
                            'sourceEditing'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    placeholder: 'Ketikkan jawabanmu disini...',
                })
                .then(editor => {
                    window.jawabanTestPraktek = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
@endsection
