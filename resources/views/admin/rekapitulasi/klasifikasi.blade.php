@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Rekapitulasi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="#">Klasifikasi</a>
                </li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

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
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekapitulasi Klasifikasi</h3>
            </div>
            <div class="card-body">
                <x-regional-filter searchType='regional'/>
                
                <div class="row mt-3">

                    <div class="col">
                    {{ $dataTable->table(['class' => 'table table-bordered table-fit', 'data-name' => 'cool-table']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>

    $(() => {
        $("#cari").click(function(e){
            const payload = {
                data: {
                    provinsi_id: $(`select[name="provinsi_id"]`).find(':selected').val(),
                    kabupaten_id: $(`select[name="kabupaten_id"]`).find(':selected').val(),
                    kecamatan_id: $(`select[name="kecamatan_id"]`).find(':selected').val(),
                    desa_id: $(`select[name="desa_id"]`).find(':selected').val(),
                    date_start: $(`input[name="date_start"]`).val(),
                    date_end: $(`input[name="date_end"]`).val()
                },
            };
            let params = $.param(payload.data);
            $('#datatable').DataTable().ajax.url(`{{ url()->current() }}?${params}`).load();
        });
    });
    $.fn.dataTable.ext.errMode = 'none';
    jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
        return this.flatten().reduce( function ( a, b ) {
            if ( typeof a === 'string' ) {
                a = a.replace(/[^\d.-]/g, '') * 1;
            }
            if ( typeof b === 'string' ) {
                b = b.replace(/[^\d.-]/g, '') * 1;
            }

            return a + b;
        }, 0 );
    } );

    </script>

@endpush
