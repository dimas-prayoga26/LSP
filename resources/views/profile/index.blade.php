@extends('layouts.app.main')
@section('title','Profile')
@section('content')
<div class="row layout-spacing">
    <div class="col-lg-6 offset-lg-3 layout-top-spacing">
        <div class="user-profile layout-spacing">
            <div class="widget-content widget-content-area p-3">
                <div class="d-flex justify-content-between">
                    <h3 class="">Info</h3>
                    <a href="{{ route('profile.edit') }}" class="mt-2 edit-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    </a>
                </div>
                @php
                    $imageProfile = asset('admin/assets/img/nopict.png');
                    if(!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                        $imageProfile = asset('storage/' . $user->photo);
                    }
                @endphp
                <div class="text-center user-info">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="avatar" width="90">
                    <p class="">{{ $user->name }}</p>
                </div>
                <div class="user-info-list">
                    <div class="">
                        <ul class="contacts-block list-unstyled">
                            <li class="contacts-block__item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                                {{ $user->role }}
                            </li>
                            <li class="contacts-block__item">
                                <a href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    {{ $user->email }}
                                </a>
                            </li>
                            <li class="contacts-block__item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                {{ $user->phone ? $user->phone : 'No Available' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
