@extends('layouts.admin')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="m-0">Kegiatan Inpres</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Manajemen Inpres</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.inpres-kegiatan.index') }}">Kegiatan</a></li>
                    <li class="breadcrumb-item">Tambah Kegiatan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    @endsection

    @section('content')
    <div class="container py-4">
        {!! Form::open([
            'route' => ['admin.inpres-kegiatan.store']
        ]) !!}

            @include('admin.inpres.kegiatan.include.form')

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>

        {!! Form::close() !!}
    </div>
@endsection