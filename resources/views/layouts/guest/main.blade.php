<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Anada - Data Science & Analytics Template">

    <title>LSP Polindra :: @yield('title')</title>

    @include('layouts.guest.style')
</head>

<body>
    @php
        $pengaturan = App\Models\Pengaturan::first();
    @endphp
    <!-- Preloader Start -->
    <div class="se-pre-con"></div>
    <!-- Preloader Ends -->
    @include('layouts.guest.navbar')
    @yield('content')

    @include('layouts.guest.footer')
    @include('layouts.guest.script')
</body>
</html>
