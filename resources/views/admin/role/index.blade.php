@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Group Setting</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="#">Hak Akses</a>
                </li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hak Akses</h3>
            </div>
            <div class="card-body">

                <div class="row mt-3">
                    <div class="col">
                        @can('create', \App\Models\Role::class)
                            <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
                                Tambah
                            </a>
                        @endcan
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush