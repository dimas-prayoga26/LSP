@extends('layouts.guest.main')
@section('title', 'Home')
@section('content')
    <!-- Start Banner
        ============================================= -->
    <div class="banner-area text-combo top-pad-90 rectangular-shape bg-light-gradient">
        <div class="item">
            <div class="box-table">
                <div class="box-cell">
                    <div class="container">
                        <div class="row">
                            <div class="double-items">
                                <div class="col-lg-6 info">
                                    <h2 class="wow fadeInDown" data-wow-duration="1s">Sertifikasi Kompetensi Politeknik Negeri
                                        Indramayu</h2>
                                    <p class="wow fadeInLeft" data-wow-duration="1.5s">
                                        Lembaga Sertifikasi Profesi Kompetensi Politeknik Negeri Indramayu bertujuan untuk
                                        memenuhi tersedianya pengakuan tenaga kerja industri sesuai bidang kerjanya dengan
                                        menggunakan klaster kompetensi yang relevan
                                    </p>
                                    <a class="btn circle btn-md btn-gradient wow fadeInUp" data-wow-duration="1.8s"
                                        href="/login">LOGIN</a>
                                </div>
                                <div class="col-lg-6 thumb wow fadeInRight text-center" data-wow-duration="1s">
                                    <img src="{{ asset('guest/assets/img/illustration/logoLSP.png') }}" alt="Thumb"
                                        width="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner -->

    <!-- Start Our Features
        ============================================= -->
    <div id="features" class="our-features-area wavesshape-bottom carousel-shadow default-padding-top">
        <div class="about-area default-padding-top text-center bg-gray">
            <div class="container">
                <div class="about-items">
                    <div class="row">
                        <div class="col-lg-7 offset-lg-2">
                            <div class="heading">
                                <h4>Skema Sertifikasi</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="container-fluid">

                        <div class="feature-items feature-carousel owl-carousel owl-theme">
                            <!-- Single Item -->
                            <div class="item">
                                <h3>Skema Sertifikasi Bekerja dengan Mesin Bubut</h3>
                                <p>
                                    Surat Keputusan Menteri Tenaga Kerja dan Transmigrasi Republik Indonesia Nomor:
                                    KEP.240/MEN/X/2004 Tanggal 19 Oktober 2004 tentang Penetapan Standar Kompetensi Kerja
                                    Nasional Indonesia Sektor Logam Mesin
                                </p>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <h3>Skema Sertifikasi Pengoperasian Pengelasan Dasar</h3>
                                <p>
                                    Surat Keputusan Menteri Tenaga Kerja dan Transmigrasi Republik Indonesia Nomor:
                                    KEP.240/MEN/X/2004 Tanggal 19 Oktober 2004 tentang Penetapan Standar Kompetensi Kerja
                                    Nasional Indonesia Sektor Logam Mesin
                                </p>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <h3>Skema Sertifikasi Pembuatan Gambar dengan CAD 3D</h3>
                                <p>
                                    Surat Keputusan Menteri Tenaga Kerja dan Transmigrasi Republik Indonesia Nomor:
                                    KEP.240/MEN/X/2004 Tanggal 19 Oktober 2004 tentang Penetapan Standar Kompetensi Kerja
                                    Nasional Indonesia Sektor Logam Mesin
                                </p>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <h3>Skema Sertifikasi Pemrograman Aplikasi Dasar</h3>
                                <p>
                                    Surat Keputusan Menteri Ketenagakerjaan Republik Indonesia Nomor 282 Tahun 2016
                                    Tanggal 8 November 2016 tentang Penetapan Standar Kompetensi Kerja Nasional Indonesia
                                    Kategori Informasi dan Komunikasi Golongan Pokok Aktivitas Pemrograman, Konsultasi
                                    Komputer dan Kegiatan YBDI Bidang Software Development Subbidang Pemrograman
                                </p>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <h3>Skema Sertifikasi Operator Komputer</h3>
                                <p>
                                    Surat Keputusan Menteri Ketenagakerjaan Republik Indonesia Nomor 285 Tahun 2016
                                    Tanggal 8 November 2016 tentang Penetapan Standar Kompetensi Kerja Nasional Indonesia
                                    Kategori Informasi dan Komunikasi Golongan Pokok Aktivitas Pemrograman, Konsultasi
                                    Komputer dan Kegiatan YBDI Bidang Computer Technical Support
                                </p>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <h3>Skema Sertifikasi Jaringan Komputer</h3>
                                <p>
                                    Surat Keputusan Menteri Ketenagakerjaan Republik Indonesia Nomor 321 Tahun 2016
                                    Tanggal 24 November 2016 tentang Penetapan Standar Kompetensi Kerja Nasional Indonesia
                                    Kategori Informasi dan Komunikasi Golongan Pokok Telekomunikasi Bidang Jaringan
                                    Komputer
                                </p>
                            </div>
                            <!-- End Single Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="waveshape">
            <img src="{{ asset('guest/assets/img/shape/6.svg') }}" alt="Shape">
        </div>
    </div>

    <!-- End Features -->

    <!-- Start Our About
        ============================================= -->
    <div id="about" class="about-area default-padding-top text-center bg-gray">
        <div class="container">
            <div class="about-items">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="heading">
                            <h4>Informasi</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="content">
                            <p>
                                Upa Lauk Politeknik Negeri Indramayu adalah Lembaga pelaksana Uji Kompetensi yang telah
                                mempunyai Lisensi sebagai Lembaga Sertifikasi Profesi Pihak Pertama (LSP P1) dari Badan
                                Nasional Sertifikasi Profesi (BNSP).
                            <p>Tujuan</p>
                            Menggunakan skema sertifikasi BNSP sebagai prosedur uji kompetensi tingkat nasional.
                            Mensosialisasikan standar kompetensi kerja nasional Indonesia (SKKNI) dan standar khusus bidang
                            keteknikan di Politeknik Negeri Indramayu.
                            Melakukan sertifikasi mahasiswa/calon lulusan/calon tenaga kerja dalam mempersiapkan
                            kebutuhantenaga kerja industry sesuai bidang kerjanya dengan menggunakan klaster kompetensi yang
                            relevan.
                            elaksanakan asesmen dan sertifikasi terhadap mahasiswa/calon lulusan sebagai calon tenaga kerja
                            diindustri.
                            </p>
                            <p>
                            <p>Sasaran</p>
                            Menerapkan standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan Standar Khusus bidang
                            keteknikan sebagai standar uji.
                            Melakukan evaluasi sejauh mana skema danStandar Khusus bidang keteknikanPoliteknik Negeri
                            Indramayu dapat diterapkan kegiatan uji sertifikasi profesi.
                            M
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Our About -->

    <!-- Start Services Area
        ============================================= -->
    <div id="services" class="services-area left-border default-padding bottom-less">

        <!-- Shape Fixed Rotation -->
        <div class="shape-fixed animation-rotation">
            <img src="{{ asset('guest/assets/img/round-shappe.png') }}" alt="Thumb">
        </div>
        <!-- Dhape Fixed Rotation -->

        <div class="container">
            <div class="heading-left">
                <div class="row">
                    <div class="col-lg-5">
                        <h2>
                            Skema Sertifikasi Politeknik Negeri Indramayu Tahun {{ date('Y') }}
                        </h2>
                    </div>
                    <div class="col-lg-6 offset-lg-1">
                        <p>
                            Terdapat 30 Skema Sertifikasi yang dapat Kamu pilih, lakukan pendaftaran untuk dapat memulai.
                        </p>
                        <a class="btn circle btn-md btn-gradient wow fadeInUp" href="javascript:void(0);">Selengkapnya <i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="services-items">
                <div class="row">
                    @forelse($skema as $data)
                        <div class="single-item col-lg-4 col-md-6">
                            <div class="item">
                                <img src="{{ asset('guest/assets/img/icon/' . $loop->iteration . '.png') }}" alt="Thumb">
                                <h4>{{ $data['judul_skema'] }}</h4>
                                <p>
                                    {{ Str::limit($data['deskripsi'], 50) }}
                                </p>
                                <div class="button">
                                    <a class="btn-standard" href="{{ route('guest.assesmen-register') }}"><i
                                            class="fas fa-angle-right"></i> Daftar Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Skema Sertifikasi Tidak Tersedia</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- End Services Area -->
    <!-- Start Contact Area
        ============================================= -->
    <div id="contact" class="contact-area default-padding">
        <div class="container">
            <div class="contact-items">
                <div class="row">
                    <div class="col-lg-4 left-item">
                        <div class="info-items">
                            <!-- Single Item -->
                            <div class="item">
                                <div class="icon">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div class="info">
                                    <h5>Location</h5>
                                    <p>
                                        22 Baker Street, London, United Kingdom, W1U 3BW
                                    </p>
                                </div>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <div class="icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info">
                                    <h5>Make a Call</h5>
                                    <p>
                                        +44-20-7328-4499
                                    </p>
                                </div>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <div class="icon">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <div class="info">
                                    <h5>Send a Mail</h5>
                                    <p>
                                        info@yourdomain.com
                                    </p>
                                </div>
                            </div>
                            <!-- End Single Item -->
                        </div>
                    </div>
                    <div class="col-lg-8 right-item">
                        <h2>We’d love to hear from you anytime</h2>
                        <form action="assets/mail/contact.php" method="POST" class="contact-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" id="name" name="name" placeholder="Name"
                                            type="text">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="email" name="email" placeholder="Email*"
                                            type="email">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="phone" name="phone" placeholder="Phone"
                                            type="text">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group comments">
                                        <textarea class="form-control" id="comments" name="comments" placeholder="Tell Us About Project *"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" id="submit">
                                        Send Message <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Alert Message -->
                            <div class="col-lg-12 alert-notification">
                                <div id="message" class="alert-msg"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->
@endsection
