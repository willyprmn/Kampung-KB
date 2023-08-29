@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Manajemen Kampung</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.kampungs.index') }}">Manajemen Kampung</a></li>
                <li class="breadcrumb-item">Tambah Kampung</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container py-4">
    <h1 class="px-3">Informasi Kampung KB</h1>
    <hr>
    {!! Form::open([
        'route' => ['admin.kampungs.store']
    ]) !!}

        @include('admin.kampung.informasi.include.form')

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Tambah</button>
        </div>

    {!! Form::close() !!}
</div>
@endsection