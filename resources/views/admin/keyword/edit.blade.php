@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Perbaharui Keyword</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.keyword.index') }}">Keyword</a></li>
                <li class="breadcrumb-item">Ubah Keyword</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container py-4">
    {!! Form::open([
        'route' => ['admin.keyword.update', ['keyword' => $keyword->id ]],
        'method' => 'PUT'

    ]) !!}

        @include('admin.keyword.include.form')

        <div class="form-group">
            @can('update', $keyword)
                <button type="submit" class="btn btn-primary">Simpan</button>
            @endcan
        </div>

    {!! Form::close() !!}
</div>
@endsection