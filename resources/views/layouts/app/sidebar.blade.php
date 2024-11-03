<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ asset('admin/assets/img/nopict.png') }}" alt="avatar">
                <h6 class="">{{ Auth::user()->name }}</h6>
                <p class="">{{ Auth::user()->role }}</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li @class(['menu', 'active' => request()->route()->getName() === 'dashboard'])>
                <a href="{{ route('dashboard') }}" aria-expanded="{{ request()->route()->getName() === 'dashboard' ? 'true': 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            @can('admin')
                @include('layouts.app.sidebarAdmin')
            @elsecan('asesi')
                @include('layouts.app.sidebarAsesi')
            @elsecan('asesor')
                @include('layouts.app.sidebarAsesor')
            @endcan
        </ul>
    </nav>
</div>
