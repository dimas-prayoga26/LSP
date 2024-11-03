@extends('layouts.app.main')
@section('title','Sertifikasi')
@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Pengguna
                        </a>
                        <div class="dropdown-menu right" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(105px, 0, 0px); top: 0px; left: 0px;">
                            <a class="dropdown-item" href="{{ route('sertifikasi.index') }}">Sertifikasi</a>
                        </div>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sertifikasi</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="d-flex justify-content-end">
                <button class="btn btn-transparent mb-2 mr-2 border dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('export.pdf') }}" class="dropdown-item">Export PDF</a>
                </div>
            </div>
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <table id="table-sertifikasi" class="table style-3 table-hover" data-route="{{ route('sertifikasi.datatable') }}">
                        <thead>
                            <tr>
                                <th class="text-center dt-no-sorting">Action</th>
                                <th>Nama Peserta</th>
                                <th>Rekomendasi</th>
                                <th>Upload Sertifikat</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('datatable')
        @include('dashboard.sertifikasi.component')
        @include('dashboard.sertifikasi.datatable')
    @endpush
@endsection
