@extends('layouts.app')

@push('analytics')
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<link rel="dns-prefetch" href="https://www.youtube.com" />
    <link rel="dns-prefetch" href="https://cdn.zingchart.com"/>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com"/>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com"/>
    <link rel="dns-prefetch" href="https://maps.googleapis.com"/>
    <link rel="dns-prefetch" href="https://googlemaps.github.io"/>
    <link rel="dns-prefetch" href="https://maps.gstatic.com"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>
    <link rel="dns-prefetch" href="https://cdn.jsdeliver.net"/>
    <link rel="dns-prefetch" href="https://code.jquery.com"/>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com"/>
    <link rel="dns-prefetch" href="https://www.google.com"/>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TXPGWJZ4QJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-TXPGWJZ4QJ');
    </script>
@endpush

@prepend('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <style>
        .bg-bkkbn-dark {
            background-color: #1a3a7b
        }

        .bg-bkkbn-light {
            background-color: #4080ff
        }
    </style>
@endprepend

@section('body')

    @include('portal.include.navbar')

    @yield('content')

    <!-- Footer -->
    <footer class="text-lg-start text-white bg-bkkbn-dark text-muted mt-md-5">
        <!-- Section: Social media -->
        <section class="container d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="d-none d-lg-block">
                <span>Kunjungi Sosial Media Kami:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="https://web.facebook.com/224293884299399" class="mx-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/BKKBNofficial" class="mx-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.instagram.com/bkkbnofficial/" class="mx-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        BKKBN
                    </h6>
                    <p>
                        Badan Kependudukan dan Keluarga Berencana Nasional
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Tautan</h6>
                    <p>
                        <a href="{{ route('portal.kampung.index') }}" class="text-reset">Jelajahi</a>
                    </p>
                    <p>
                    <a href="{{ route('portal.percontohan') }}" class="text-reset">Percontohan</a>
                    </p>
                    <p>
                    <a href="{{ route('portal.statistik.index') }}" class="text-reset">Statistik</a>
                    </p>
                    <p>
                    <a href="{{ route('portal.tentang') }}" class="text-reset">Tentang Kampung KB</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Lebih Lanjut</h6>
                    <p>
                        <a href="https://bkkbn.go.id/" class="text-reset">Portal BKKBN</a>
                    </p>
                    <p>
                        <a href="https://www.bkkbn.go.id/category/berita-terbaru" class="text-reset">Berita</a>
                    </p>
                    <p>
                        <a href="https://www.bkkbn.go.id/pages/struktur-organisasi" class="text-reset">Struktur Organisasi</a>
                    </p>
                    <p>
                        <a href="https://www.bkkbn.go.id/contact" class="text-reset">Kontak</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Kontak</h6>
                    <p>
                        <i class="fas fa-home mx-3"></i>
                        Jl. Permata No. 1, Halim Perdanakusuma Jakarta Timur, 13650
                    </p>
                    <p>
                        <i class="fas fa-envelope mx-3"></i>
                        admin.web@bkkbn.go.id
                    </p>
                    <p><i class="fas fa-phone mx-3"></i>021-8098018</p>
                    <p><i class="fas fa-print mx-3"></i>021-8008554</p>
                </div>
                <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © {{ date('Y') }} Copyright:
        <a class="text-reset fw-bold" href="https://bkkbn.go.id/">BKKBN</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->

@endsection

@push('scripts')
    <script>
        let numbers = $('.colnum');
        numbers.map((key, value) => {
            let num = parseFloat(value.innerHTML).toLocaleString('id-ID');
            if (num !== 'NaN') {
                numbers[key].innerHTML = num;
            }
        });
    </script>
@endpush