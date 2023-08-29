@extends('layouts.portal')

@section('title') {{ $page->title }} @endsection
@section('description') Tentang Kampung KB @endsection
@section('canonical', route('portal.tentang'))

@push('analytics')

    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:description" content="Tentang Kampung KB" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('portal.tentang') }}" />
    <meta property="og:image" content="{{ $image['base64'] ?? asset('images/infografik.jpg') }}" />
    <meta property="og:site_name" content="BKKBN" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": "{{ $page->title }}",
            "url": "{{ route('portal.tentang') }}",
            "datePublished": "2021-12-03T22:00:50+07:00",
            "image": "{{ $image['base64'] ?? asset('images/infografik.jpg') }}",
            "thumbnailUrl": "{{ $image['base64'] ?? asset('images/infografik.jpg') }}"
        }
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row mt-md-5 py-5">
            <div class="col-lg-6">
                <h3 class="fw-bold lh-3 mb-3"><u>Tentang Kampung KB</u></h3>
                <h1 class="display-5 fw-bold lh-1 mb-3">{{ $page->title }}</h1>
            </div>
        </div>

        <div class="row pb-5">
            <div class="card">
                <div class="card-body">
                    <img src="{{ $image['base64'] ?? asset('images/infografik.jpg') }}" class="d-block w-100" alt="{{ $page->title }}">
                </div>
            </div>
        </div>

        <div class="row pb-5">
            <div class="card">
                <div class="card-body">
                    {!! $page->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection
