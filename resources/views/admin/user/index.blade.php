@extends('layouts.admin')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Manajemen User</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">User</a>
                    </li>
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
                    <h3 class="card-title">User</h3>
                </div>
                <div class="card-body">

                    <x-regional-filter-auth table-id="admin-user-table">
                        <x-slot name="options">
                            <div class="col">
                                @can('create', \App\Models\User::class)
                                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary float-right">
                                        Tambah
                                    </a>
                                @endcan
                            </div>
                        </x-slot>
                    </x-regional-filter-auth>
                    <div>
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