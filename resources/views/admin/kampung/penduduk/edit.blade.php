@extends('layouts.admin')


@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<style>
    .icheck-container {
        padding-top: calc(.375rem + 1px)!important;
    }

    .d-inline {
        margin-right: 1rem!important;
    }

    .form-group.row {
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    }

    input[type=number] {
        text-align: end!important;
    }

</style>
@endpush

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Kampung: {{ $kampung->nama }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.kampungs.index') }}">Manajemen Kampung</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kampungs.show', ['kampung' => $kampung->id]) }}">{{ $kampung->nama }}</a></li>
                <li class="breadcrumb-item"><a href="#">Laporan Perkembangan</a></li>
                <li class="breadcrumb-item">Profil Kependudukan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
{!! Form::open([
    'route' => ['admin.kampungs.penduduk.store', ['kampung' => $kampung->id]]
]) !!}
<div class="container">

    @include('admin.kampung.penduduk.include.form')

    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection