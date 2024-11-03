<li class="menu menu-heading">
    <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        <span>MASTER DATA</span>
    </div>
</li>
<li @class(['menu','active' => request()->routeIs('kelompokAsesor.*') || request()->routeIs('event.*') || request()->routeIs('skema.*') || request()->routeIs('unitKompetensi.*') || request()->routeIs('elemen.*') || request()->routeIs('kriteriaUnjukKerja.*') || request()->routeIs('berkasPemohon.*')])>
    <a href="#perangkat-assesmen" data-toggle="collapse" aria-expanded="{{ request()->routeIs('kelompokAsesor.*') || request()->routeIs('event.*') || request()->routeIs('skema.*') || request()->routeIs('unitKompetensi.*') || request()->routeIs('elemen.*') || request()->routeIs('kriteriaUnjukKerja.*') || request()->routeIs('berkasPemohon.*') ? 'true' : 'false' }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            <span>Perangkat Assesmen</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul @class(['collapse','submenu','list-unstyled','show' => request()->routeIs('kelompokAsesor.*') || request()->routeIs('event.*') || request()->routeIs('skema.*') || request()->routeIs('unitKompetensi.*') || request()->routeIs('elemen.*') || request()->routeIs('kriteriaUnjukKerja.*') || request()->routeIs('berkasPemohon.*')]) id="perangkat-assesmen" data-parent="#accordionExample">
        <li @class(['active' => request()->routeIs('kelompokAsesor.*')])>
            <a href="{{ route('kelompokAsesor.index') }}"> Assign Asesor </a>
        </li>
        <li @class(['active' => request()->routeIs('event.*')])>
            <a href="{{ route('event.index') }}"> Event </a>
        </li>
        <li @class(['active' => request()->routeIs('skema.*')])>
            <a href="{{ route('skema.index') }}"> Skema  </a>
        </li>
        <li @class(['active' => request()->routeIs('unitKompetensi.*')])>
            <a href="{{ route('unitKompetensi.index') }}"> Unit Kompetensi </a>
        </li>
        <li @class(['active' => request()->routeIs('elemen.*')])>
            <a href="{{ route('elemen.index') }}"> Elemen </a>
        </li>
        <li @class(['active' => request()->routeIs('kriteriaUnjukKerja.*')])>
            <a href="{{ route('kriteriaUnjukKerja.index') }}"> Kriteria Unjuk Kerja </a>
        </li>
        <li @class(['active' => request()->routeIs('berkasPemohon.*')])>
            <a href="{{ route('berkasPemohon.index') }}"> Berkas Permohonan </a>
        </li>
    </ul>
</li>
<li @class(['menu','active' => request()->routeIs('ujianTulis.*') || request()->routeIs('ujianPraktek.*') || request()->routeIs('ujianWawancara.*')])>
    <a href="#kategori-ujian" data-toggle="collapse" aria-expanded="{{ request()->routeIs('ujianTulis.*') || request()->routeIs('ujianPraktek.*') || request()->routeIs('ujianWawancara.*') ? 'true' : 'false' }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
            <span>Kategori Test</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul @class(['collapse','submenu','list-unstyled','show' => request()->routeIs('ujianTulis.*') || request()->routeIs('ujianPraktek.*') || request()->routeIs('ujianWawancara.*')]) id="kategori-ujian" data-parent="#accordionExample">
        {{-- <li @class(['active' => request()->routeIs('ujianTulis.*')])>
            <a href="{{ route('ujianTulis.index') }}"> Test Tulis </a>
        </li>
        <li @class(['active' => request()->routeIs('ujianPraktek.*')])>
            <a href="{{ route('ujianPraktek.index') }}"> Test Praktek </a>
        </li> --}}
        <li @class(['active' => request()->routeIs('ujianWawancara.*')])>
            <a href="{{ route('ujianWawancara.index') }}"> Test Wawancara </a>
        </li>
    </ul>
</li>
<li @class(['menu','active' => request()->routeIs('jurusan.*') || request()->routeIs('kelas.*')])>
    <a href="#instrumen-pendukung" data-toggle="collapse" aria-expanded="{{ request()->routeIs('jurusan.*') || request()->routeIs('kelas.*') ? 'true' : 'false' }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>Instrumen Pendukung</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul @class(['collapse','submenu','list-unstyled','show' => request()->routeIs('jurusan.*') || request()->routeIs('kelas.*')]) id="instrumen-pendukung" data-parent="#accordionExample">
        <li @class(['active' => request()->routeIs('jurusan.*')])>
            <a href="{{ route('jurusan.index') }}"> Jurusan </a>
        </li>
        <li @class(['active' => request()->routeIs('kelas.*')])>
            <a href="{{ route('kelas.index') }}"> Kelas </a>
        </li>
    </ul>
</li>
<li @class(['menu','active' => request()->routeIs('asesor.*') || request()->routeIs('asesi.*') || request()->routeIs('sertifikasi.*')])>
    <a href="#users" data-toggle="collapse" aria-expanded="{{ request()->routeIs('asesor.*') || request()->routeIs('asesi.*') || request()->routeIs('sertifikasi.*') ? 'true' : 'false' }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Pengguna</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul @class(['collapse','submenu','list-unstyled','show' => request()->routeIs('asesor.*') || request()->routeIs('asesi.*') || request()->routeIs('sertifikasi.*')]) id="users" data-parent="#accordionExample">
        <li @class(['active' => request()->routeIs('asesor.*')])>
            <a href="{{ route('asesor.index') }}"> Asesor </a>
        </li>
        <li @class(['active' => request()->routeIs('asesi.*')])>
            <a href="{{ route('asesi.index') }}"> Asesi </a>
        </li>
        <li @class(['active' => request()->routeIs('sertifikasi.*')])>
            <a href="{{ route('sertifikasi.index') }}"> Sertifikasi </a>
        </li>
    </ul>
</li>


<li class="menu menu-heading">
    <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>PENGATURAN UMUM</span></div>
</li>

<li @class(['menu', 'active' => request()->route()->getName() === 'pengaturan'])>
    <a href="{{ route('pengaturan') }}" aria-expanded="{{ request()->route()->getName() === 'pengaturan' ? 'true': 'false' }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            <span>Pengaturan</span>
        </div>
    </a>
</li>
