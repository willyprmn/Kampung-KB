@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Konfigurasi</a></li>
                <li class="breadcrumb-item"><a href="#">Tooltip Statistik</a></li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="px-3">Konfigurasi Tooltip Statistik</h1>
    {!! Form::open([
        'route' => ['admin.configuration.statistik.update'],
        'method' => 'PUT'
    ]) !!}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Report Statistik</div>
                </div>
                <div class="card-body">
                    @foreach($configurations as $key => $item)
                        {{ Form::hidden(
                            'statistiks[' . $key . '][id]',
                            $item->id
                        ) }}
                        <div class='row'>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-sm-8 col-form-label">
                                    {{ $key + 1 }}.  {{ $item->title }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="title_{{ $key }}"
                                        class="col-sm-8 col-form-label @error('statistiks.{{ $key }}.title') text-danger @enderror">
                                        Title
                                        @error('statistiks.{{ $key }}.title')
                                            <br>
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </label>
                                    {{ Form::textarea(
                                        'statistiks[' . $key . '][title]',
                                        $item->title,
                                        ['rows' => 2, 'class' => $errors->has('statistiks.' . ($key) . '.title') ? 'form-control is-invalid' : 'form-control']
                                    ) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="description_{{ $key }}"
                                        class="col-sm-8 col-form-label @error('statistiks.{{ $key }}.description') text-danger @enderror">
                                        Description
                                        @error('statistiks.{{ $key }}.description')
                                            <br>
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </label>
                                    {{ Form::textarea(
                                        'statistiks[' . $key . '][description]',
                                        $item->description,
                                        ['rows' => 2, 'class' => $errors->has('statistiks.' . ($key) . '.description') ? 'form-control is-invalid' : 'form-control ']
                                    ) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tooltip_{{ $key }}"
                                        class="col-sm-8 col-form-label @error('statistiks.{{ $key }}.tooltip') text-danger @enderror">
                                        Tooltip
                                        @error('statistiks.{{ $key }}.tooltip')
                                            <br>
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </label>
                                    {{ Form::textarea(
                                        'statistiks[' . $key . '][tooltip]',
                                        $item->tooltip,
                                        ['rows' => 2, 'class' => $errors->has('statistiks.' . ($key) . '.tooltip') ? 'form-control is-invalid' : 'form-control']
                                    ) }}
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    {!! Form::close() !!}

</div>
@endsection


