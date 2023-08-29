@extends('layouts.admin')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="m-0">Sasaran Inpres</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Manajemen Inpres</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.inpres-sasaran.index') }}">Sasaran</a></li>
                    <li class="breadcrumb-item">Ubah Sasaran</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    @endsection

    @section('content')
    <div class="container py-4">
        {!! Form::open([
            'route' => ['admin.inpres-sasaran.update', ['inpres_sasaran' => $sasaran->id]],
            'method' => 'PUT'
        ]) !!}

            @include('admin.inpres.sasaran.include.form')

            @can('update', $sasaran)
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            @endcan
        {!! Form::close() !!}
    </div>
@endsection