@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Perubahan Instansi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.instansi.index') }}">Instansi</a></li>
                <li class="breadcrumb-item">Edit Instanssi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container py-4">
    {!! Form::open([
        'route' => ['admin.instansi.update', ['instansi' => $instansi->id]],
        'method' => 'PUT'
    ]) !!}

        @include('admin.instansi.include.form')

        @can('update', $instansi)
            <div class="form-group">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        @endcan

    {!! Form::close() !!}
</div>
@endsection