@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Perubahan User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Manajemen User</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">User</a></li>
                <li class="breadcrumb-item">Perbaharui User</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container py-4">
        {!! Form::open([
            'route' => ['admin.user.update', ['user' => $user->id]],
            'method' => 'PUT'
        ]) !!}

            @include('admin.user.include.form')

            <div class="form-group">
                @can('update', $user)
                    <button type="submit" class="btn btn-success">Simpan</button>
                @endcan
            </div>

        {!! Form::close() !!}
    </div>
@endsection