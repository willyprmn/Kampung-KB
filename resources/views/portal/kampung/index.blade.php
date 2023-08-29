@extends('layouts.portal')

@section('title') Jelajahi Kampung KB di Indonesia @endsection
@section('description') Daftar seluruh KB di Indonesia Berdasarkan Wilayahnya @endsection
@section('canonical', route('portal.kampung.index'))

@push('analytics')

    <meta property="og:title" content="Jelajahi Kampung KB di Indonesia" />
    <meta property="og:description" content="Daftar seluruh KB di Indonesia Berdasarkan Wilayahnya" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('portal.kampung.index') }}" />
    <meta property="og:image" content="{{ asset('images/bkkbn.png') }}" />
    <meta property="og:site_name" content="BKKBN" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": "Jelajahi Kampung KB di Indonesia",
            "url": "{{ route('portal.kampung.index') }}",
            "datePublished": "2021-12-03T22:00:50+07:00",
            "image": "{{ asset('images/bkkbn.png') }}",
            "thumbnailUrl": "{{ asset('images/bkkbn.png') }}"
        }
    </script>
@endpush

@section('content')
<div class="container">

    <div class="row g-5 py-5">
        <div class="col">
            <h1>Jelajahi Kampung KB di Indonesia</h1>
        </div>
    </div>
    <div class="row">
        <x-regional-filter searchType='regional'/>
    </div>
    <div class="row">
        <div class="col" style="overflow: scroll;">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')

    {{ $dataTable->scripts() }}

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $(() => {

            $(`input[name="cari"]`).on('click', () => {
                const payload = {
                    data: {
                        provinsi_id: $(`select[name="provinsi_id"]`).find(':selected').val(),
                        kabupaten_id: $(`select[name="kabupaten_id"]`).find(':selected').val(),
                        kecamatan_id: $(`select[name="kecamatan_id"]`).find(':selected').val(),
                        desa_id: $(`select[name="desa_id"]`).find(':selected').val(),
                    },
                };
                let params = $.param(payload.data);
                $('#datatable').DataTable().ajax.url(`{{ url()->current() }}?${params}`).load();
            });
        });

    </script>

@endpush
