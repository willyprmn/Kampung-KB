@extends('layouts.portal')

@section('title') Percontohan Kampung KB di Indonesia @endsection
@section('description') Daftar Percontohan Kampung KB di Indonesia @endsection
@section('canonical', route('portal.percontohan'))

@push('analytics')

    <meta property="og:title" content="Percontohan Kampung KB di Indonesia" />
    <meta property="og:description" content="Daftar Percontohan Kampung KB di Indonesia" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('portal.percontohan') }}" />
    <meta property="og:image" content="{{ $image['base64'] ?? asset('images/bkkbn.png') }}" />
    <meta property="og:site_name" content="BKKBN" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": "Percontohan Kampung KB di Indonesia",
            "url": "{{ route('portal.percontohan') }}",
            "datePublished": "2021-12-03T22:00:50+07:00",
            "image": "{{ $image['base64'] ?? asset('images/bkkbn.png') }}",
            "thumbnailUrl": "{{ $image['base64'] ?? asset('images/bkkbn.png') }} }}"
        }
    </script>
@endpush

@push('styles')
    <style>
        .dt-buttons.btn-group {
            margin-bottom: 1.5rem!important;
        }

        td.colnum {
            text-align: end;
        }

        .table thead th {
            text-align: center!important;
            vertical-align: middle!important;
        }

        .dataTables_wrapper.dt-bootstrap4 {
            overflow: scroll!important;
        }


        table.table-fit {
            width: auto !important;
            table-layout: auto !important;
        }
        table.table-fit thead th, table.table-fit tfoot th {
            width: auto !important;
        }
        table.table-fit tbody td, table.table-fit tfoot td {
            width: auto !important;
        }

    </style>
@endpush
@section('content')
<div class="container">

    <div class="row g-5 py-5">
        <div class="col">
            <h1>Percontohan Kampung KB di Indonesia</h1>
        </div>
    </div>
    <div class="row">
        <x-regional-filter searchType='percontohan'/>
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
                        percontohan_type: $(`select[name="percontohan_type"]`).find(':selected').val(),
                    },
                };
                let params = $.param(payload.data);
                $('#datatable').DataTable().ajax.url(`{{ url()->current() }}?${params}`).load();
            });
        });

    </script>

@endpush
