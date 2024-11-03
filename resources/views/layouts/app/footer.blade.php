@php
    $pengaturan = App\Models\Pengaturan::value('application_footer');
    $footer = 'Copyright © ' . date('Y') .' LSP POLINDRA All rights reserved';

    if($pengaturan != null) {
        $footer = $pengaturan;
    }
@endphp
<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">{{ $footer }}</p>
    </div>
</div>
