@extends('portal.page.statistic.index')

@section('title') Statistik - {{ $statistik->title }} | BKKBN @endsection
@section('description') {{ $statistik->description }} @endsection
@section('canonical', route('portal.statistik.show', [
    'statistik' => $statistik->id,
    'slug' => Str::slug($statistik->title)
]))

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

    <div class="d-md-flex">
        <h1 id="content">Jumlah Kampung KB Menurut Kategori Program dan Kegiatan</h1>
    </div>
    <div class="form-group">
        <br>
        <label class="form-label">

        </label>
        <div class="panel-group" role="tablist">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                <h4 class="panel-title">
                    <a class="collapsed btn btn-success" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="false" aria-controls="collapseListGroup1">
                    Tampilkan Pilihan Table Program
                    </a>
                </h4>
                </div>
                <div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1">
                <ul class="list-group">
                    @foreach($statistics as $key => $item)

                    <li class="list-group-item">
                        <a class="list-group-item list-group-item-action {{ ($statistik->id == $item->id) ? 'active' : '' }}"
                            href="{{ route('portal.statistik.show', ['statistik' => $item->id, 'slug' => Str::slug($item->title)] ) }}"
                            data-toggle="tooltip" data-placement="top">
                            {{ $item->title }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <x-regional-filter searchType='date-range'/>
    <button id="btnExport" onclick="fnExcelReport();" class="btn btn-secondary buttons-excel"> Excel </button>

    {{ $dataTable->table(['class' => 'table table-bordered table-fit', 'data-name' => 'cool-table']) }}

@endsection

@push('scripts')

<script src="{{ asset('js/exceljs.min.js') }}"></script>
<script src="{{ asset('js/table2excel.core.js') }}"></script>

<script>
    $(() => {
        console.log(`{{ url()->current() }}`);
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

            switch(true){
                case payload.data.provinsi_id !== '' && payload.data.kabupaten_id === '' && payload.data.kecamatan_id === '' :
                    $($('#datatable').DataTable().column(1).header()).text('Provinsi - ' + $(`select[name="provinsi_id"]`).find(':selected').text());
                    break;
                case payload.data.provinsi_id !== '' && payload.data.kabupaten_id !== '' && payload.data.kecamatan_id === '' :
                    $($('#datatable').DataTable().column(1).header()).text('Kabupaten - ' + $(`select[name="kabupaten_id"]`).find(':selected').text());
                    break;
                case payload.data.provinsi_id !== '' && payload.data.kabupaten_id !== '' && payload.data.kecamatan_id !== '' :
                    $($('#datatable').DataTable().column(1).header()).text('Kecamatan - ' + $(`select[name="kecamatan_id"]`).find(':selected').text());
                    break;
                case payload.data.desa_id !== '' :
                    $($('#datatable').DataTable().column(1).header()).text('Desa - ' + $(`select[name="desa_id"]`).find(':selected').text());
                    break;
                default :
                    $($('#datatable').DataTable().column(1).header()).text('Provinsi');
                    break;
            }
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

    function generateHeader(){
        if ($('#titleHeader').length) { $('#titleHeader').remove(); }
        var length = document.getElementById('datatable').rows[0].cells.length;

        $('#datatable thead') // select table thead
            .prepend('<tr id=titleHeader>') // prepend table row
            .children('tr:first') // select row we just created
            .append('<td colspan=' + length + ' align=center /><strong> ' + {!! json_encode($statistik->description) !!} + ' <br> Periode : ' + $('input[name=date_start]').val() + '</strong>'
        );

    }
    function fnExcelReport()
    {
        const table2Excel = new Table2Excel('table');
        table2Excel.export("statistik-" + {!! json_encode($statistik->title) !!}, 'xlsx');
        return false;
        $("#datatable").table2excel({
            exclude: ".noExl",
            name: {!! json_encode($statistik->title) !!},
            filename: "statistik-" + {!! json_encode($statistik->title) !!} + '.xlsx',
            fileExtension: ".xlsx",
        });
    }
</script>
{{ $dataTable->scripts() }}
<script>
    $();
</script>
@endpush

