@extends('layouts.guest.main')
@section('title','Register Assemen')
@section('content')
    <div class="breadcrumb-area gradient-bg text-light text-center">
        <!-- Fixed BG -->
        <div class="fixed-bg" style="background-image: url({{ asset('guest/assets/img/shape/1.png') }});"></div>
        <!-- Fixed BG -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1>FORM PENDAFTARAN (SERTIFIKASI ASESMEN)</h1>
                    <ul class="breadcrumb">
                        <li><a href="/"><i class="fas fa-home"></i> Home</a></li>
                        <li class="active">Form Pendaftaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="contact" class="contact-area default-padding">
        <div class="container">
            <div class="contact-items">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 right-item">
                        <h2>Form Pendaftaran Akun Assesmen</h2>
                        @if(session('error') || session('success'))
                            <div @class(['alert','alert-dismissible','fade','show', 'alert-success' => session('success'), 'alert-danger' => session('error')]) role="alert">
                                @if(session('success')) <strong>Register Successfull!</strong> {{ session('success') }} @else <strong>Register Failed!</strong> {{ session('error') }} @endif
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="name" name="name" placeholder="Name*" type="text" autofocus required value="{{ old('name') }}">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="nim" name="nim" placeholder="NIM/NPM*" type="number" autofocus required value="{{ old('nim') }}">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="email" name="email" placeholder="Email*" type="email" required value="{{ old('email') }}">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="phone" name="phone" placeholder="08*****" required value="{{ old('phone') }}">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select name="jurusan_id" onchange="handleSelectJurusan(this)" id="jurusan_id" class="form-control" required>
                                            <option value="" selected disabled>Pilih jurusan*</option>
                                            @forelse($jurusan as $data)
                                                <option value="{{ $data['uuid'] }}">{{ $data['nama_jurusan'] }}</option>
                                            @empty
                                                <option value="" selected disabled>Data kosong</option>
                                            @endforelse
                                        </select>
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select name="kelas_id" id="kelas_id" class="form-control" required>
                                            <option value="" selected disabled>Pilih kelas*</option>
                                        </select>
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="password*" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password*" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="captcha col-5" draggable="false">
                                    {!! Captcha::img() !!}
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" id="captcha" name="captcha" class="form-control @error('captcha') is-invalid @enderror @if(session()->has('failed-captcha')) is-invalid @endif" required placeholder="Kode Captcha">
                                        @error('captcha')
                                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                        @if($message = session()->get('failed-captcha'))
                                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                        @endif                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="reload d-block" id="reloadCaptcha">&#x21bb; Reload captcha</a>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" id="submit">
                                        Daftar Sekarang <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function handleSelectJurusan(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var jurusanUuid = selectedOption.getAttribute('value');
            getKelas(jurusanUuid);
        }

        function getKelas(jurusanUuid) {
            $.ajax({
                type: 'GET',
                url: '{{ route('kelas.listByUuid','') }}' + '/' + jurusanUuid,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    var kelasSelect = $('#kelas_id');
                    kelasSelect.empty();
                    if (response.data.length > 0) {
                        kelasSelect.append(new Option('Pilih kelas*', ''));
                        response.data.forEach(function(kelas) {
                            kelasSelect.append(new Option(kelas.nama_kelas, kelas.id));
                        });
                    } else {
                        kelasSelect.append(new Option('Data kelas kosong', ''));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan');
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('reloadCaptcha').onclick = function () {
            axios.get('/captcha-refresh').then(function (response) {
                document.querySelector('.captcha').innerHTML = response.data.captcha;
            });
        }
    </script>
@endsection
