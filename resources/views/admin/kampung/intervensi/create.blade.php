@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Kampung: {{ $kampung->nama }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.index') }}">
                        Manajemen Kampung
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.show', ['kampung' => $kampung->id]) }}">
                        {{ $kampung->nama }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">
                        Intervensi
                    </a>
                </li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@section('content')
<div class="container">
    <h2 class="my-4">Intervensi / Kegiatan</h2>
    <div id="intervensi-component"
        current="{{ url()->current() }}"
        store="{{ route('admin.kampungs.intervensi.store', ['kampung' => $kampung->id]) }}"
        callback="{{ route('admin.kampungs.show', ['kampung' => $kampung->id]) }}">
        <div class="card">
            <div class="overlay">
                <i class="fas fa-2x fa-sync-alt"></i>
            </div>
            <div class="card-header">
                <div class="card-title">Memuat...</div>
            </div>
            <div class="card-body">
                <p>Mengambil data dari database</p>
            </div>
        </div>
    </div>
</div>
@endsection