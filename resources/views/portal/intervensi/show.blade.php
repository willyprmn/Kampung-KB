@extends('layouts.portal')

@section('title') {{ $intervensi->judul }} @endsection
@section('description') {{ substr(strip_tags($intervensi->deskripsi), 0, 150) }} ... @endsection
@section('canonical', route('portal.kampung.intervensi.show', [
    'kampung_id' => $intervensi->kampung->id,
    'intervensi_id' => $intervensi->id,
    'slug' => Str::slug($intervensi->judul)
]))

@push('styles')

    <link rel="preload" href="{{ photo($intervensi->intervensi_gambars->first()->path ?? '') }}" as="image">
    <style>

        .blur-background {
            width: 100%!important;
            height: 15rem!important;
            position: relative;
        }


        @media (min-width: 576px) {
            .blur-background {
                height: 10rem!important;
            }
        }

        @media (min-width: 768px) {
            .blur-background {
                height: 30rem!important;
            }
        }



    </style>

    @foreach($intervensi->intervensi_gambars as $key => $item)
        <style>
            .blur-background-{{ $key }}::before {

                background-image: url('{{ photo($item->path ?? '') }}');
                background-position: center!important;
                background-size: cover!important;
                content: "";
                position: absolute;
                width : 100%;
                height: 100%;
                /* background: inherit; */

                z-index: -1!important;
                filter: blur(8px)!important;
                -webkit-filter: blur(8px)!important;
                -moz-filter: blur(8px)!important;
                -o-filter: blur(8px)!important;
                -ms-filter: blur(8px)!important;
            }

        </style>
    @endforeach
@endpush

@push('analytics')

    <meta property="og:title" content="{{ $intervensi->judul }}" />
    <meta property="og:description" content="{{ substr(strip_tags($intervensi->deskripsi), 0, 150) }} ..." />
    <meta property="og:type" content="article" />
    <meta property="og:article:published_time" content="{{ $intervensi->tanggal->toIso8601String() }}" />
    <meta property="og:article:modified_time" content="{{ $intervensi->updated_at ? $intervensi->updated_at->toIso8601String() : $intervensi->tanggal->toIso8601String() }}" />
    {{-- <meta property="og:article:author" content="article" /> --}}
    <meta property="og:article:section" content="{{ $intervensi->kategori->name ?? 'N/A' }}" />
    <meta property="og:url" content="{{ route('portal.kampung.intervensi.show', [
        'kampung_id' => $intervensi->kampung->id,
        'intervensi_id' => $intervensi->id,
        'slug' => Str::slug($intervensi->judul)
    ]) }}" />
    <meta property="og:image" content="{{ photo($intervensi->intervensi_gambars->first()->path ?? '') }}" />
    <meta property="og:site_name" content="BKKBN" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": "{{ $intervensi->judul }}",
            "url": "{{ route('portal.kampung.intervensi.show', [
                'kampung_id' => $intervensi->kampung->id,
                'intervensi_id' => $intervensi->id,
                'slug' => Str::slug($intervensi->judul)
            ]) }}",
            "datePublished": "{{ $intervensi->tanggal->toIso8601String() }}",
            "image": "{{ photo($intervensi->intervensi_gambars->first()->path ?? '') }}",
            "thumbnailUrl": "{{ photo($intervensi->intervensi_gambars->first()->path ?? '') }}"
        }
    </script>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Beranda",
                "item": "{{ route('portal.home') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "{{ $intervensi->kampung->nama }}",
                "item": "{{ route('portal.kampung.show', ['kampung_id' => $intervensi->kampung->id, 'slug' => Str::slug($intervensi->kampung->nama)]) }}"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": "Intervensi",
                "item": "{{ route('portal.kampung.intervensi.index', ['kampung_id' => $intervensi->kampung->id]) }}"
            }
        ]}
    </script>


    <script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Article",
			"mainEntityOfPage": {
				"@type": "WebPage",
				"@id": "{{ route('portal.kampung.intervensi.show', [
                    'kampung_id' => $intervensi->kampung->id,
                    'intervensi_id' => $intervensi->id,
                    'slug' => Str::slug($intervensi->judul)
                ]) }}"
			},
			"headline": "{{ $intervensi->judul }}",
			"image": {
				"@type": "ImageObject",
			    "url": "{{ photo($intervensi->intervensi_gambars->first()->path ?? '') }}"
            },
			"datePublished": "{{ $intervensi->tanggal->toIso8601String() }}",
			"dateModified": "{{ $intervensi->updated_at ? $intervensi->updated_at->toIso8601String() : $intervensi->tanggal->toIso8601String() }}",
			"author": {
				"@type": "Organization",
				"name": "BKKBN",
                "url": "https://bkkbn.go.id"
			},
			"publisher": {
				"@type": "Organization",
				"name": "BKKBN",
				"logo": {
					"@type": "ImageObject",
					"url": "{{ asset('images/bkkbn.png') }}"
				}
			},
			"description": "{{ substr(strip_tags($intervensi->deskripsi), 0, 150) }}"
		}
    	</script>

@endpush

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <article>
                <header class="my-5">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">{{ $intervensi->judul }}</h1>
                    <!-- Post meta content-->
                    @if (!empty($intervensi->kampung->nama))
                        <div class="text-muted fst-italic mb-2">{{ $intervensi->kampung->nama }}</div>
                    @endif
                    <div class="text-muted fst-italic mb-2">Dipublikasi pada {{ $intervensi->tanggal->format('d F Y') }}</div>
                    <!-- Post categories-->
                    {{-- <a class="badge bg-secondary text-decoration-none link-light" href="#!">Web Design</a>
                    <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a> --}}
                </header>

                <div id="carouselintervensi" class="carousel slide mb-4" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($intervensi->intervensi_gambars as $key => $item)
                            <li data-target="#carouselintervensi" data-slide-to="{{ $key }}" class="active"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($intervensi->intervensi_gambars as $key => $item)
                        <div class="carousel-item blur-background blur-background-{{ $key }} {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ photo($item->path ?? '') }}" class="d-block w-100" style="z-index: 9999!important; object-fit:contain; height: 100%; width: 100%;" alt="{{ $item->caption }}">
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselintervensi" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselintervensi" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <section class="mb-4" style="overflow: scroll;">
                    <h2>Deskripsi</h2>
                    {!! $intervensi->deskripsi !!}
                </section>

                <section class="mb-4">
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                  Sesi Kegiatan <span class="text-primary" style="float: right;"><strong>{{ $intervensi->program->name ?? 'N/A' }}</strong></span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                  Sesi Kegiatan <span class="text-primary" style="float: right;"><strong>{{ $intervensi->kategori->name ?? 'N/A' }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2>Instansi Pembina Kegiatan</h2>
                    <div class="row">
                        <div class="col">
                            @forelse($intervensi->instansis as $key => $instansi)
                                <button class="btn btn-primary mb-1">{{ $instansi->name }}</button>
                            @empty
                                <p>Tidak ada</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2>Sasaran Kegiatan</h2>
                    <div class="row">
                        <div class="col">
                            @forelse($intervensi->sasarans as $key => $sasaran)
                                <button class="btn btn-primary mb-1">{{ $sasaran->name }}</button>
                            @empty
                                <p>Tidak ada</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
</div>
@endsection