@extends('layouts.admin')

@push('styles')
<style>
    #admin-kampung-profil-table, #admin-kampung-penduduk-table, #admin-kampung-kkbpk-table, #admin-kampung-intervensi-table, #admin-kampung-kkbpk-table {
        width: 100%!important;
    }
    #admin-kampung-profil-table_filter, #admin-kampung-penduduk-table_filter, #admin-kampung-kkbpk-table_filter {
        display: none!important;
    }
</style>
@endpush

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Manajemen Kampung KB</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.index') }}">Manajemen Kampung</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $kampung->nama }}
                </li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="kampung-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="informasi-tab" data-toggle="pill" href="#informasi" role="tab" aria-controls="informasi" aria-selected="true">
                    Informasi Kampung KB
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="laporan-tab" data-toggle="pill" href="#laporan" role="tab" aria-controls="laporan" aria-selected="false">
                    Laporan Perkembangan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="intervensi-tab" data-toggle="pill" href="#intervensi" role="tab" aria-controls="intervensi" aria-selected="false">
                    Intervensi
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="informasi" role="tabpanel" aria-labelledby="informasi-tab">
                @include('admin.kampung.informasi.show')
            </div>
            <div class="tab-pane fade" id="laporan" role="tabpanel" aria-labelledby="laporan-tab">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="laporan-child-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profil-tab" data-toggle="pill" href="#profil" role="tab" aria-controls="profil" aria-selected="true">Profil Kampung KB</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="penduduk-tab" data-toggle="pill" href="#penduduk" role="tab" aria-controls="penduduk" aria-selected="false">Profil Penduduk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kkbpk-tab" data-toggle="pill" href="#kkbpk" role="tab" aria-controls="kkbpk" aria-selected="false">Perkembangan Program Bangga Kencana</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="laporan-child-tabContent">
                            <div class="tab-pane fade active show" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                                @can('create', [\App\Models\ProfilKampung::class, $kampung])
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('admin.kampungs.profil.create', ['kampung' => $kampung->id]) }}"
                                                style="float: right;"
                                                class="btn btn-primary">
                                                Update
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                {{ $profilDataTable
                                    ->with('kampung', $kampung)
                                    ->html()
                                    ->table()
                                }}
                            </div>
                            <div class="tab-pane fade" id="penduduk" role="tabpanel" aria-labelledby="penduduk-tab">
                                @can('create', [\App\Models\PendudukKampung::class, $kampung])
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('admin.kampungs.penduduk.create', ['kampung' => $kampung->id]) }}"
                                                style="float: right;"
                                                class="btn btn-primary">
                                                Update
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                {{ $pendudukDataTable
                                    ->with('kampung', $kampung)
                                    ->html()
                                    ->table()
                                }}
                            </div>
                            <div class="tab-pane fade" id="kkbpk" role="tabpanel" aria-labelledby="kkbpk-tab">
                                @can('create', [\App\Models\Kkbpk::class, $kampung])
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('admin.kampungs.kkbpk.create', ['kampung' => $kampung->id]) }}"
                                                style="float: right;"
                                                class="btn btn-primary">
                                                Update
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                {{ $kkbpkDataTable
                                    ->with('kampung', $kampung)
                                    ->html()
                                    ->table()
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="intervensi" role="tabpanel" aria-labelledby="intervensi-tab">
                @can('create', [\App\Models\Intervensi::class, $kampung])
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('admin.kampungs.intervensi.create', ['kampung' => $kampung->id]) }}"
                                style="float: right;"
                                class="btn btn-primary">
                                Tambah
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="row mt-4">
                    <div class="col">
                        {{ $intervensiDataTable
                            ->with('kampung', $kampung)
                            ->html()
                            ->table()
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{ $profilDataTable->with('kampung', $kampung)->html()->scripts() }}
{{ $pendudukDataTable->with('kampung', $kampung)->html()->scripts() }}
{{ $intervensiDataTable->with('kampung', $kampung)->html()->scripts() }}
{{ $kkbpkDataTable->with('kampung', $kampung)->html()->scripts() }}

<script type="text/javascript">
    var hash = location.hash.replace(/^#/, '');  // ^ means starting, meaning only match the first hash
    if (hash) {
        $('.nav-tabs a[href="#' + hash + '"]').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    })
</script>
@endpush