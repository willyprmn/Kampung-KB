@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Pembuatan User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Manajemen User</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">User</a></li>
                <li class="breadcrumb-item">Tambah User</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container py-4">
        {!! Form::open([
            'route' => ['admin.user.store']
        ]) !!}

            @include('admin.user.include.form')

            <div class="form-group">
                @can('create', \App\Models\User::class)
                    <button type="submit" class="btn btn-primary">Tambah</button>
                @endcan
            </div>

        {!! Form::close() !!}
    </div>
@endsection