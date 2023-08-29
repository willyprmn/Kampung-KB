@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Inpres Program</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Manajemen Inpres</a></li>
                <li class="breadcrumb-item"><a href="#">Inpres Program</a></li>
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
                    <h3 class="card-title">Daftar Program</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">

                        <div class="col">
                            <a href="{{ route('admin.inpres-program.create') }}" class="btn btn-primary float-right">
                                Tambah
                            </a>
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
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush