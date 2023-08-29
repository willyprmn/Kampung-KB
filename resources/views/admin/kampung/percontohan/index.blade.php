@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Manajemen Percontohan Kampung KB </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Percontohan</a></li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kampung KB</h3>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <x-regional-filter searchType='percontohan'/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {{ $dataTable->table() }}
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

<script>

    $(() => {
        var provinsi_id = {{ $provinsi_id ?? 'null' }};
        if(provinsi_id !== null){
            $('select[name="provinsi_id"]').val(provinsi_id).change();
            $('select[name="provinsi_id"]').attr("disabled", true);

            var name = $('select[name="provinsi_id"]').find(":selected").text();
            var desas = `<option selected value="` + provinsi_id + `">` + name + `</option>`;
            $(`select[name="provinsi_id"]`).html(desas);

        }

        $("#cari").click(function(e){
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