@php
    $kelas_id = optional(Auth::user()->asesi)->kelas_id;
    $current_time = Carbon\Carbon::now();

    $kelompokAsesor = App\Models\KelompokAsesor::where('kelas_id', $kelas_id)
        ->whereHas('event', function($query) use ($current_time) {
            $query->where('event_mulai', '<=', $current_time)
                ->where('event_selesai', '>=', $current_time);
        })
        ->with(['event' => function($query) use ($current_time) {
            $query->where('event_mulai', '<=', $current_time)
                ->where('event_selesai', '>=', $current_time);
        }])
        ->get();

    $idUrl = request()->segment(2);

    if(request()->routeIs('persetujuanAssesmen.*') ||
    request()->routeIs('frapl.*') ||
    request()->routeIs('frapl01.*') ||
    request()->routeIs('frapl02.*') ||
    request()->routeIs('userTestTulis.*') ||
    request()->routeIs('userTestPraktek.*') ||
    request()->routeIs('userTestWawancara.*') ||
    request()->routeIs('checklistObservasi.*') ||
    request()->routeIs('testAssesmen.index')
    ) {
        $idUrl = request()->query->keys()[0];
    }
@endphp

<li class="menu menu-heading">
    <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        <span>Perangkat Assesmen</span>
    </div>
</li>
<li @class(['menu',
    'active' => request()->routeIs('event-asesi.*') ||
    request()->routeIs('persetujuanAssesmen.*') ||
    request()->routeIs('frapl.*') ||
    request()->routeIs('frapl01.*') ||
    request()->routeIs('frapl02.*') ||
    request()->routeIs('userTestTulis.*') ||
    request()->routeIs('userTestPraktek.*') ||
    request()->routeIs('userTestWawancara.*') ||
    request()->routeIs('checklistObservasi.*') ||
    request()->routeIs('testAssesmen.index')
    ])>
    <a href="#kategori-ujian" data-toggle="collapse" aria-expanded="{{ request()->routeIs('event-asesi.*') ||
        request()->routeIs('persetujuanAssesmen.*') ||
        request()->routeIs('frapl.*') ||
        request()->routeIs('frapl01.*') ||
        request()->routeIs('frapl02.*') ||
        request()->routeIs('userTestTulis.*') ||
        request()->routeIs('userTestPraktek.*') ||
        request()->routeIs('userTestWawancara.*') ||
        request()->routeIs('checklistObservasi.*') ||
        request()->routeIs('testAssesmen.index') ? 'true' : 'false' }}" class="dropdown-toggle">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
            <span>Event Saya</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul @class(['collapse','submenu','list-unstyled',
        'show' => request()->routeIs('event-asesi.*') ||
        request()->routeIs('persetujuanAssesmen.*') ||
        request()->routeIs('frapl.*') ||
        request()->routeIs('frapl01.*') ||
        request()->routeIs('frapl02.*') ||
        request()->routeIs('userTestTulis.*') ||
        request()->routeIs('userTestPraktek.*') ||
        request()->routeIs('userTestWawancara.*') ||
        request()->routeIs('checklistObservasi.*') ||
        request()->routeIs('testAssesmen.index')
    ]) id="kategori-ujian" data-parent="#accordionExample">
        @forelse($kelompokAsesor as $data)
            <li @class(['active' => request()->routeIs('event-asesi.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('persetujuanAssesmen.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('frapl.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('frapl01.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('frapl02.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('userTestTulis.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('userTestPraktek.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('userTestWawancara.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('checklistObservasi.*') && $idUrl === $data['uuid'] ||
                request()->routeIs('testAssesmen.index') && $idUrl === $data['uuid']
            ])>
                <a class="text-wrap" href="{{ route('event-asesi.show', $data['uuid']) }}"> {{ $data->event['nama_event'] }} </a>
            </li>
        @empty
            <li class="active">
                <a href="javascript:void(0);"> Event tidak ada </a>
            </li>
        @endforelse
    </ul>
</li>
