@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Pembuatan Program Group</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.program-group.index') }}">Program Group</a></li>
                <li class="breadcrumb-item">Tambah Program Group</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container py-4">
    {!! Form::open([
        'route' => ['admin.program-group.store']
    ]) !!}

        @include('admin.program-group.include.form')

        @can('create', \App\Models\ProgramGroup::class)
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        @endcan
    {!! Form::close() !!}
</div>
@endsection