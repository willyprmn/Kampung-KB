@extends('layouts.admin')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">User</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Profile</a>
                    </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="section-image" data-image="../../assets/img/bg5.jpg" ;="">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-6">
                        <form class="form" method="" action="">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">Profile</h4>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Email/Username</label>
                                                <input type="text" class="form-control" disabled="" placeholder="Email/Username" readonly value="{{ $user->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hak Akses</label>
                                                <ul>
                                                    @foreach ($user->roles as $key => $role)
                                                        <li>{{ $role->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Provinsi</label>
                                                <input type="text" class="form-control" disabled="" placeholder="Provinsi" readonly value="{{ $user->provinsi->name ?? ''  }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Kabupaten</label>
                                                <input type="text" class="form-control" disabled="" placeholder="Kabupaten" readonly value="{{ $user->kabupaten->name ?? ''  }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Kecamatan</label>
                                                <input type="text" class="form-control" disabled="" placeholder="Kecamatan" readonly value="{{ $user->kecamatan->name ?? ''  }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Desa</label>
                                                <input type="text" class="form-control" disabled="" placeholder="Desa" readonly value="{{ $user->desa->name ?? ''  }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <a href="{{ route('admin.profile.edit') }}"
                                                    class="btn btn-success">
                                                    Ubah Password
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="card-body ">
                                <div class="author">
                                    <a href="#">
                                        <div class="avatar border-gray" style="margin-left: auto; margin-right: auto;">
                                            <img style="max-width: 100%" src="{{ asset('images/user.png') }}">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
