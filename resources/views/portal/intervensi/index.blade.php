@extends('layouts.portal')

@section('title') Daftar Kegiatan {{ ucwords($kampung->nama) }} @endsection
@section('description') {{ substr(strip_tags($kampung->gambaran_umum), 0, 150) }} ... @endsection
@section('canonical', route('portal.kampung.intervensi.index', [
    'kampung_id' => $kampung->id,
]))

@push('styles')
    <link rel="preload" href="{{ photo($kampung->path_gambar) }}" as="image">
    <style>
        .jumbotron {
            background-position: center;
            background-image: url('{{ photo($kampung->path_gambar) }}');
            background-size: cover;
            margin-bottom: 0;
        }

        .navigation {
            background-color: rgba(0,0,0, 0.7);
        }

        .jumbotron-light {
            color: white;
        }

        a.link-card {
            text-decoration: none!important;
            color: #212529!important;
        }

        a.link-card:hover {
            text-decoration: none!important;
            color: #0d6efd!important;
        }
    </style>
@endpush

@push('analytics')
    <meta property="og:title" content="Daftar Kegiatan {{ ucwords($kampung->nama) }}" />
    <meta property="og:description" content="{{ substr(strip_tags($kampung->gambaran_umum), 0, 150) }} ..." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('portal.kampung.intervensi.index', [
        'kampung_id' => $kampung->id
    ]) }}" />
    <meta property="og:image" content="{{ photo($kampung->path_gambar) }}" />
    <meta property="og:site_name" content="BKKBN" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": "{{ ucwords($kampung->nama) }}",
            "url": "{{ route('portal.kampung.show', [
                'kampung_id' => $kampung->id,
            ]) }}",
            "datePublished": "{{ $kampung->tanggal_pencanangan->toIso8601String() }}",
            "image": "{{ photo($kampung->path_gambar) }}",
            "thumbnailUrl": "{{ photo($kampung->path_gambar) }}"
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
                "name": "{{ $kampung->nama }}",
                "item": "{{ route('portal.kampung.show', ['kampung_id' => $kampung->id, 'slug' => Str::slug($kampung->nama)]) }}"
            }
        ]}
    </script>
@endpush

@section('content')
    <header class="container-fluid pt-md-5 pb-0 jumbotron">
        <div class="container pt-md-5 mt-md-5 border-bottom jumbotron-light">
            <div class="row mb-5">
                <div class="col-md-8 pl-4 py-4 navigation">
                    <h3 class="fw-bold mb-3">Intervensi</h3>
                    <h1 class="display-5 fw-bold mb-4">{{ $kampung->nama }}</h1>
                    <a href="{{ route('portal.kampung.show', [
                        'kampung_id' => $kampung->id,
                        'slug' => Str::slug($kampung->nama)
                    ]) }}" class="btn btn-primary btn-lg" type="button">Kembali</a>
                </div>
            </div>
        </div>
    </header>

<div class="container">

    <x-navbar.kategori />

    <div class="row my-4">
        <div class="col">
            @forelse($intervensis as $key => $intervensi)
                <a href="{{ route('portal.kampung.intervensi.show', [
                    'kampung_id' => $kampung->id,
                    'intervensi_id' => $intervensi->id,
                    'slug' => Str::slug($intervensi->judul)
                ]) }}" class="link-card">
                    <div class="card mb-3" style="overflow: hidden;">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text">
                                        <small class="text-muted">{{ $intervensi->tanggal->format('d F Y') }}</small>
                                    </p>
                                    <h5 class="card-title">{{ $intervensi->judul }}</h5>
                                    {{-- <p class="card-text">{!! $intervensi->deskripsi !!}</p> --}}
                                </div>
                            </div>
                            <div style="background-image: url('{{ photo($intervensi->intervensi_gambar->path ?? '') }}'); background-position: center; background-size: cover;"
                                class="col-md-4">
                                <img class="float-end img-fluid" style="height: 10rem; visibility:  hidden;"
                                    src="{{ photo($intervensi->intervensi_gambar->path ?? '') }}"
                                    alt="{{ $intervensi->judul }}">
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <h2 class="text-center">Data tidak tersedia</h2>
            @endforelse

            {{ $intervensis->links() }}
        </div>
    </div>
</div>
@endsection