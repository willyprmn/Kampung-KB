@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Manajemen Kampung KB</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Manajemen Kampung KB</a></li>
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

                    <x-regional-filter-auth table-id="admin-kampung-table">
                        <x-slot name="options">
                            @can('create', \App\Models\Kampung::class)
                                <div class="col">
                                    <a href="{{ route('admin.kampungs.create') }}" class="btn btn-primary float-right">
                                        Tambah
                                    </a>
                                </div>
                            @endcan
                        </x-slot>
                    </x-regional-filter-auth>
                    <div class="row mt-3">
                        <div class="col">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@prepend('scripts')
    {{ $dataTable->scripts() }}
@endprepend