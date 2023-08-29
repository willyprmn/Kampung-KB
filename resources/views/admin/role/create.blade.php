@extends('layouts.admin')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Group Setting</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Group Setting</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container">

        {!! Form::open([
            'route' => ['admin.role.store'],
        ]) !!}

            @include('admin.role.include.form')

            <div class="row">
                <div class="col-sm-12">
                    @can('create', \App\Models\Role::class)
                        <button type="submit" class="btn btn-success">Simpan</button>
                    @endcan
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@endsection