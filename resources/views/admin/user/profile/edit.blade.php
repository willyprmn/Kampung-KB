@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Formulir Perubahan Password</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Manajemen Profile</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">User</a></li>
                <li class="breadcrumb-item">Perbaharui Password</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container py-4">
        {!! Form::open([
            'route' => ['admin.profile.update'],
            'method' => 'PUT'
        ]) !!}

            <div class="row row-cols-2">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Ubah Password</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="email"
                                    class="form-label @error('email') text-danger @enderror">
                                    Email/Username
                                </label>
                                {{ Form::text(
                                    'email',
                                    $user->email ?? null,
                                    ['class' => $errors->has('email') ? 'is-invalid form-control' : 'form-control', 'disabled']
                                ) }}
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password"
                                    class="form-label @error('password') text-danger @enderror">
                                    Password Lama
                                </label>
                                <input id="password_old" type="password" class="form-control @error('password_old') is-invalid @enderror" name="password_old" required autocomplete="current-password">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password"
                                    class="form-label @error('password') text-danger @enderror">
                                    Password Baru
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation"
                                    class="form-label @error('password_confirmation') text-danger @enderror">
                                    Konfirmasi Password
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">

                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>

        {!! Form::close() !!}
    </div>
@endsection