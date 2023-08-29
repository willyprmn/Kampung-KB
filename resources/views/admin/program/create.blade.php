@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Pembuatan Program</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.program.index') }}">Program</a></li>
                <li class="breadcrumb-item">Tambah Program</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container py-4">
    {!! Form::open([
        'route' => ['admin.program.store']
    ]) !!}

        @include('admin.program.include.form')

        @can('create', \App\Models\Program::class)
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        @endcan
    {!! Form::close() !!}
</div>
@endsection