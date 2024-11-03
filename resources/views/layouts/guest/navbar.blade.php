<header id="home">
    <nav class="navbar navbar-default navbar-fixed-light attr-border navbar-fixed dark no-background bootsnav">
        <div class="container">
            <div class="attr-nav">
                <ul>
                    <li class="side-menu"><a href="#"><i class="ti-menu-alt"></i></a></li>
                </ul>
            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="javascript:void(0);">
                    @if(isset($pengaturan['application_logo']) && $pengaturan['application_logo'])
                        <img class="mr-3" 
                             src="{{ asset('storage/'.$pengaturan['application_logo']) }}" 
                             class="logo default" 
                             alt="Logo" 
                             width="50">
                    @else
                        <img class="mr-3" 
                             src="{{ asset('admin/assets/img/300x300.jpg') }}" 
                             class="logo default" 
                             alt="Logo" 
                             width="50">
                    @endif
                    <img class="mr-3" 
                         src="{{ asset('guest/assets/img/logo/bnsp.svg') }}" 
                         class="logo default" 
                         alt="Logo" 
                         width="150">
                    <img src="{{ asset('guest/assets/img/logo/ristekdikti.svg') }}" 
                         class="logo default" 
                         alt="Logo" 
                         width="63">
                    @if(isset($pengaturan['application_logo']) && $pengaturan['application_logo'])
                        <img src="{{ asset('storage/'.$pengaturan['application_logo']) }}" 
                             class="logo logo-responsive" 
                             alt="Logo">
                    @else
                        <img src="{{ asset('admin/assets/img/300x300.jpg') }}" 
                             class="logo logo-responsive" 
                             alt="Logo">
                    @endif
                </a>
                          
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="active">
                        <a class="smooth-menu" href="#home">Home</a>
                    </li>
                    <li>
                        <a class="smooth-menu" href="#features">Skema Sertifikasi</a>
                    </li>
                    <li>
                        <a class="smooth-menu" href="#about">Informasi</a>
                    </li>
                    <li>
                        <a class="smooth-menu" href="#services">Tentang Kami</a>
                    </li>
                    <li>
                        <a class="smooth-menu" href="#contact">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="side">
            <a href="#" class="close-side"><i class="ti-close"></i></a>
            <div class="widget">
                <h4 class="title">Contact Info</h4>
                <ul class="contact">
                    <li>
                        <div class="icon">
                            <i class="flaticon-email"></i>
                        </div>
                        <div class="info">
                            <span>Email</span> Info@gmail.com
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <i class="flaticon-call-1"></i>
                        </div>
                        <div class="info">
                            <span>Phone</span> +123 456 7890
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <i class="flaticon-countdown"></i>
                        </div>
                        <div class="info">
                            <span>Office Hours</span> Sat - Wed : 8:00 - 4:00
                        </div>
                    </li>
                </ul>
            </div>
            <div class="widget">
                <h4 class="title">Additional Links</h4>
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                </ul>
            </div>
            <div class="widget social">
                <h4 class="title">Connect With Us</h4>
                <ul class="link">
                    <li class="facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="pinterest"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                    <li class="dribbble"><a href="#"><i class="fab fa-dribbble"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
