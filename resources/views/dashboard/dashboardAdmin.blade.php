<style>
.widget {
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 15px;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.widget:hover {
    transform: translateY(-5px);
}

.w-icon img {
    max-width: 50px;
    margin-right: 15px; /* Mengatur jarak antara gambar dan value */
}

.w-content {
    display: flex;
    align-items: center; /* Pastikan value dan teks sejajar secara vertikal dengan gambar */
}

.w-content h6.value {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    display: flex;
    align-items: center;
    margin: 0; /* Menghilangkan margin default */
}

.w-content .description {
    font-size: 14px;
    color: #777;
    margin-left: 5px; /* Mengatur jarak antara value dan description */
}



</style>

<div class="row layout-top-spacing">
    <!-- Asesi -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget widget-card-four">
            <div class="widget-content d-flex align-items-center">
                <div class="w-icon">
                    <img src="{{ asset('profile.png') }}" alt="Asesor Icon" style="width: 50px;">
                </div>
                <div class="w-content d-flex align-items-center">
                    <h6 class="value mb-0 d-flex align-items-center">
                        <span>{{ $totalAsesi }}</span>
                        <span class="description ms-1">Asesi</span>
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Asesor -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget widget-card-four">
            <div class="widget-content d-flex align-items-center">
                <div class="w-icon">
                    <img src="{{ asset('teamwork.png') }}" alt="Asesi Icon" style="width: 50px;">
                </div>
                <div class="w-content d-flex align-items-center">
                    <h6 class="value mb-0 d-flex align-items-center">
                        <span>{{ $totalAsesor }}</span>
                        <span class="description ms-1">Asesor</span>
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Skema -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget widget-card-four">
            <div class="widget-content d-flex align-items-center">
                <div class="w-icon">
                    <img src="{{ asset('process.png') }}" alt="Skema Icon" style="width: 50px;">
                </div>
                <div class="w-content d-flex align-items-center">
                    <h6 class="value mb-0 d-flex align-items-center">
                        <span>{{ $totalSkema }}</span>
                        <span class="description ms-1">Skema</span>
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Event -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget widget-card-four">
            <div class="widget-content d-flex align-items-center">
                <div class="w-icon">
                    <img src="{{ asset('calendar.png') }}" alt="Event Icon" style="width: 50px;">
                </div>
                <div class="w-content d-flex align-items-center">
                    <h6 class="value mb-0 d-flex align-items-center">
                        <span>{{ $totalEvent }}</span>
                        <span class="description ms-1">Event</span>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
