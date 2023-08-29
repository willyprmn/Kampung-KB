@extends('layouts.portal')

@section('title'){{ $page->title }}@endsection
@section('description') {{ $page->description }} @endsection
@section('canonical', route('portal.home'))

@push('styles')

    <link rel="preload" href="{{ $image }}" as="image">
    <style>
        .bg-text {
            background-color: rgba(0,0,0, 0.5);
        }
        .blueline {
            width: 32px;
            height: 4px;
            background-color: #13a7e8;
            margin-left: 0px;
            margin-top: -2px;
            border: 0px;
        }

        .item-height {
            width: 100%!important;
            height: 15vw!important;
            position: relative;
        }


        @media (max-width: 575.98px) {
            .item-height {
                width: 100%!important;
                height: 35vw!important;
                position: relative;
            }
        }

        .border-md {
           border-width: 2px !important;
        }

    </style>
@endpush

@section('head')
    <script src="{{ asset('js/zingchart.min.js') }}"></script>
@endsection

@push('analytics')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:description" content="{{ $page->description }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('portal.home') }}" />
    <meta property="og:image" content="{{ url($image) }}" />
    <meta property="og:site_name" content="BKKBN" />
    {{-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> --}}
    <script type='application/ld+json'>
        {
            "@context" : "https://schema.org",
            "@type" : "Organization",
            "name" : "BKKBN",
            "url" : "https://bkkbn.go.id/",
            "sameAs" : [
                "https://web.facebook.com/BKKBNOfficial",
                "https://twitter.com/bkkbnofficial",
                "https://www.instagram.com/bkkbnofficial/"
            ],
            "logo": "{{ url($image) }}"
        }
    </script>
    <script type="application/ld+json">
    	{
    		"@context": "https://schema.org",
    		"@type": "WebPage",
    		"headline": "{{ $page->title }}",
    		"url": "{{ route('portal.home') }}",
    		"datePublished": "2021-12-03T22:00:50+07:00",
    		"image": "{{ $image }}",
    		"thumbnailUrl": "{{ $image }}"
    	}
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "{{ route('portal.home') }}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "{{ route('portal.kampung.index') }}?cari={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
@endpush

@section('content')

    <header class="text-white"
        style="background-image: url({{ $image }}); background-size: cover;"
    >
        <div class="container" style="padding-top: 25rem;">
            <div class="row py-md-5">
                <div class="col col-md-7 bg-text px-md-4">
                    <h1 class="display-5 my-4 fw-bold lh-1">{{ $page->title }}</h1>
                    <p class="lead my-4">{!! $page->description !!}</p>
                    <div class="row my-4">
                        <div class="col">
                            <a class="btn btn-primary px-3 mx-1 mb-3 " href="{{ route('portal.tentang') }}">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col col-md-5 bg-text px-md-4">
                    <h5 class="display-5 my-4 fw-bold lh-1">Total kampung KB sudah dicanangkan<h5>
                    <h2 class="display-1 colnum">{{ $kampung_total }}</h2>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section>
            <div class="container my-3">
                <div class="row pb-md-5">
                    <div class="col-12 col-md-6">
                        <a class="bd-toc-link" href="#" data-toggle="tooltip" data-placement="top"
                            title="Kampung KB terpilih adalah 10 kampung kb terpilih yang paling banyak melakukan kegiatan, rutin melaporkan capaian program, melakukan updating profil penduduk dan profil kampung KB">
                            <h3 class="mb-2 ml-md-3 mt-md-4 text-dark">Profil Kampung Terpilih</h3>
                        </a>
                        <hr class="blueline ml-md-3">
                        <div id="carouselterpilih" style="width: 100%;" class="carousel slide mb-3" data-ride="carousel">
                            <div class="carousel-inner shadow">
                                @foreach($kampung_terpilih as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <figure class="rounded p-md-3">
                                            <div class="item-height"
                                                style="background-image: url('{{ photo($item->path_gambar) }}'); background-size: cover; background-position: center;"></div>
                                            <img src="{{ photo($item->path_gambar) }}" alt="{{ $item->nama }}" loading="lazy" style="display: none;" class="w-100 card-img-top">
                                            <figcaption class="p-2 p-md-3 card-img-bottom bg-white">
                                                <a href="{{ route('portal.kampung.show', ['kampung_id' => $item->id, 'slug' => Str::slug($item->nama)]) }}">
                                                    <h3 style="text-overflow: ellipsis;" class="h6 font-weight-bold mb-2">{{ $item->nama }}</h2>
                                                    <small class="mb-0 text-small text-muted"><i class="Lokasi__Icon fa fa-map-marker-alt"></i> {{ $item->provinsi ?? '' }} > {{ $item->kabupaten ?? '' }} > {{ $item->kecamatan ?? '' }} > {{ $item->desa ?? '' }}</small>
                                                </a>
                                            </figcaption>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselterpilih" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselterpilih" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <a class="bd-toc-link" href="#" data-toggle="tooltip" data-placement="top"
                            title="Kampung Kb terupdate adalah 10 kampung KB yang melakukan updating">
                            <h3 class="mb-2 ml-md-3 mt-md-4 text-dark">Profil Kampung Terupdate</h3>
                        </a>
                        <hr class="blueline ml-md-3">
                        <div id="carouselterupdate" style="width: 100%;" class="carousel slide mb-3" data-ride="carousel">
                            <div class="carousel-inner shadow">
                                @foreach($kampung_terupdate as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <figure class="rounded p-md-3">
                                            <div class="item-height"
                                                style="background-image: url('{{ photo($item->path_gambar) }}'); background-size: cover; background-position: center;"></div>
                                            <img src="{{ photo($item->path_gambar) }}" alt="{{ $item->nama }}" style="display: none;" class="w-100 card-img-top">
                                            <figcaption class="p-2 p-md-3 card-img-bottom bg-white">
                                                <a href="{{ route('portal.kampung.show', ['kampung_id' => $item->id, 'slug' => Str::slug($item->nama)]) }}">
                                                    <h3 style="text-overflow: ellipsis;" class="h6 font-weight-bold mb-2">{{ $item->nama }}</h2>
                                                    <small class="mb-0 text-small text-muted"><i class="Lokasi__Icon fa fa-map-marker-alt"></i> {{ $item->provinsi->name ?? '' }} > {{ $item->kabupaten->name ?? '' }} > {{ $item->kecamatan->name ?? '' }} > {{ $item->desa->name ?? '' }}</small>
                                                </a>
                                            </figcaption>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselterupdate" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselterupdate" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light">
            <div class="container">
                <x-card.program />
            </div>
        </section>

        <section>
            <div class="container">
                <x-card.inpres />
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row g-md-5 py-md-2">
                    <div class="col">
                        <x-chart.lintas-sektor :kampungTotal="$kampung_total" />
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row g-md-5 py-md-2 mb-3 mb-md-0">
                    <div class="col-md-6">
                        <x-maps />
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-2 ml-md-2">Video</h2>
                        <hr class="blueline ml-md-2">
                        <div class="col">
                            <div class="embed-responsive embed-responsive-16by9">
                                @switch($conf->source)
                                    @case('url')
                                        <iframe
                                            class="embed-responsive-item"
                                            loading="lazy"
                                            src="{{ $conf->value}}"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                        @break
                                    @case('file')
                                        <video controls
                                            class="embed-responsive-item"
                                            loading="lazy">
                                            <source src="{{ Storage::url($conf->value) }}" type="{{ Storage::mimeType($conf->value) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script defer>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
@endpush
