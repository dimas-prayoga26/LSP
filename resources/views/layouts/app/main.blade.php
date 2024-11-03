<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $pengaturan = App\Models\Pengaturan::value('application_prefix_title');
        $prefixTitle = 'LSP Polindra';
        if($pengaturan != null) {
            $prefixTitle = $pengaturan;
        }
    @endphp
    <title>{{ $pengaturan }} @yield('title')</title>
    @include('layouts.app.style')
</head>
<body @class(['sidebar-noneoverflow' => !request()->routeIs('login') && !request()->routeIs('password.request') && !request()->routeIs('password.reset'), 'form' => request()->routeIs('login') && request()->routeIs('password.request') && request()->routeIs('password.reset')])>
    @if(!request()->routeIs('login') && !request()->routeIs('password.request') && !request()->routeIs('password.reset'))
        <div id="load_screen"> <div class="loader"> <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div></div></div>
        @include('layouts.app.header')
        <div class="main-container" id="container">
            <div class="overlay"></div>
            <div class="search-overlay"></div>
            @include('layouts.app.sidebar')
            <div id="content" class="main-content">
                <div class="layout-px-spacing">
                    @yield('content')
                </div>
                @include('layouts.app.footer')
            </div>
        </div>
    @else
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap p-5">
                    <div class="form-content">
                        @yield('authentication')
                        <p class="terms-conditions">© 2020 All Rights Reserved. <a href="javascript:void(0)">LSP Polindra</a> is a product of Designreset. <a href="javascript:void(0);">Cookie Preferences</a>, <a href="javascript:void(0);">Privacy</a>, and <a href="javascript:void(0);">Terms</a>.</p>
                    </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image"></div>
        </div>
    </div>
    @endif
    @include('layouts.app.script')
    @stack('datatable')
    @include('layouts.app.component')
</body>
</html>
