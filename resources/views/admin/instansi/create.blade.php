@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Pembuatan Instansi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.instansi.index') }}">Instansi</a></li>
                <li class="breadcrumb-item">Tambah Instansi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container py-4">
    {!! Form::open([
        'route' => ['admin.instansi.store']
    ]) !!}

        @include('admin.instansi.include.form')

        @can('create', \App\Models\Role::class)
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        @endcan

    {!! Form::close() !!}
</div>
@endsection