@extends('layouts.app.main')

@section('title','Login')

@section('authentication')
    <h1 class="text-center"> Selamat Datang Di <br> LSP Polindra </h1>

    @if(session('status_account'))
        <div class="alert alert-icon-left alert-light-danger mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12" y2="17"></line>
            </svg>
            <strong>Warning!</strong> {{ session('status_account') }}
        </div>
    @endif

    <!-- Tombol Login dengan Google -->
    <div class="text-center mb-4">
        <a href="" class="btn btn-light btn-block">
            <img src="{{ asset('google.png') }}" alt="Google Icon" width="20" class="mr-2"> <!-- Ganti dengan URL ikon Google yang sesuai -->
            Masuk dengan Google
        </a>
    </div>

    <div class="text-center text-muted mb-3">
        <span>atau lanjutkan dengan</span>
    </div>

    <form class="text-left" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form">
            <div id="username-field" class="field-wrapper input">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                </svg>
                <input id="credential" name="credential" type="credential" class="form-control @error('credential') is-invalid @enderror" placeholder="Masukan email/NIM/NIP/username" value="{{ old('credential') }}" required>
                @error('credential')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div id="password-field" class="field-wrapper input mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="field-wrapper input mb-2 row">
                <div class="captcha col-5" draggable="false">
                    {!! Captcha::img() !!}
                </div>
                <div class="col-7">
                    <input type="text" id="captcha" name="captcha" class="form-control @error('captcha') is-invalid @enderror @if(session()->has('failed-captcha')) is-invalid @endif" required placeholder="Kode Captcha">
                    @error('captcha')
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                    @if($message = session()->get('failed-captcha'))
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @endif
                </div>
                <a href="javascript:void(0);" class="reload d-block" id="reloadCaptcha">&#x21bb; Reload captcha</a>
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper toggle-pass">
                    <p class="d-inline-block">Show Password</p>
                    <label class="switch s-primary">
                        <input type="checkbox" id="toggle-password" class="d-none">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary">Log In</button>
                </div>
            </div>
            <div class="field-wrapper text-center keep-logged-in">
                <div class="n-chk new-checkbox checkbox-outline-primary">
                    <label for="remember_me" class="new-control new-checkbox checkbox-outline-primary">
                        <input type="checkbox" id="remember_me" class="new-control-input" name="remember">
                        <span class="new-control-indicator"></span>Keep me logged in
                    </label>
                </div>
            </div>
            @if (Route::has('password.request'))
                <div class="field-wrapper">
                    <a href="{{ route('password.request') }}" class="forgot-pass-link">Forgot Password?</a>
                </div>
            @endif
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('reloadCaptcha').onclick = function () {
            axios.get('/captcha-refresh').then(function (response) {
                document.querySelector('.captcha').innerHTML = response.data.captcha;
            });
        }
    </script>
@endsection
