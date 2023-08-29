@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <style>
        .icheck-container {
            padding-top: calc(.375rem + 1px)!important;
        }

        .d-inline {
            margin-right: 1rem!important;
        }

        .sona-container .sonas .sona .preview-details {
            background: #333;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            padding: 0px;
            padding-right: 8px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            justify-content: flex-end;
        }

        .sona-container .sonas .sona .preview-caption {
            background: #333;
            color: #fff;
            padding: 16px;
            border: none;
            margin-right: 8px;
            font-size: 17px;
            line-height: 20px;
            font-weight: 500;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            border-bottom-left-radius: 3px;
            text-overflow: ellipsis;
            overflow: hidden;
            word-wrap: break-word;
        }

        .sona-container .sonas .sona .preview-image {
            width: 100%;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            background: #333;
        }

        .preview-change-image {
            margin-top: .5rem;
            margin-bottom: .5rem;
        }

        .sonas .sona {
            margin-bottom: 1rem;
        }

        .hidden {
            display: none;
        }
    </style>
@endpush

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Konfigurasi</a></li>
                <li class="breadcrumb-item"><a href="#">Header</a></li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="px-3">Konfigurasi Header</h1>
    {!! Form::open([
        'route' => ['admin.page.update'],
        'method' => 'PUT',
        'files' => true
    ]) !!}
    {{ Form::hidden(
        "type",
        'header'
    ) }}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Deskripsi</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title"
                            class="col-sm-8 col-form-label @error('title') text-danger @enderror">
                            Judul
                            @error('title')
                                <br>
                                <small>{{ $message }}</small>
                            @enderror
                        </label>
                        {{ Form::text(
                            'title',
                            $page->title,
                            ['class' => $errors->has('title') ? 'col-sm-4 form-control is-invalid' : 'col-sm-4 form-control']
                        ) }}
                    </div>
                    <div class="form group">
                        {{ Form::label('', 'Gambar') }}
                        <div class="sona-container">
                            <fieldset id="fieldsetKegiatan">
                                <div class="sonas">
                                    <div class="sona">
                                        <img class="preview-image col-4" src="{{ old('image.base64') ?? $image['base64'] ?? asset('images/hero.webp') }}" alt="Preview">
                                        <span class="preview-details col-4">
                                            {{ Form::hidden(
                                                "image[base64]",
                                                old('image.base64'),
                                                ['class' => 'base-image']
                                            ) }}

                                            {{ Form::file(
                                                "gambar[file]",
                                                [
                                                    'accept' => 'image/*',
                                                    'class' => 'uploader-input hidden'
                                                ]
                                            ) }}
                                            <button type='button' class="preview-change-image btn btn-primary">
                                                Pilih Gambar
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(
                            'description',
                            'Deskripsi Tentang Program *',
                            ['class' => $errors->has('description') ? 'text-danger' : '']
                        ) }}
                        {{ Form::textarea(
                            'description',
                            $page->description ?? null,
                            ['id' => 'description', 'class' => 'w-50']
                        ) }}
                        @error("description") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label(
                            'video',
                            'Video Tampilan Muka *',
                            ['class' => $errors->has('video') ? 'text-danger' : '']
                        ) }}

                        <div class="w-50 icheck-container">
                            <div class="icheck-primary">
                                {{ Form::radio(
                                    "src",
                                    'url',
                                    $conf->source === 'url',
                                    ['id' => "videourl"]
                                ) }}
                                <label for="videourl" class="mt-2">Dari URL: </label>
                                {{ Form::text('video', $conf->value, ['class' => 'form-control d-inline-block w-50 ml-1']) }}

                            </div>
                            <div class="icheck-primary">
                                {{ Form::radio(
                                    "src",
                                    'file',
                                    $conf->source === 'file',
                                    ['id' => "videofile"]
                                ) }}
                                <label for="videofile" class="mt-2">Dari File Upload: </label>
                                {{ Form::file('video', ['class' => 'form-control d-inline-block w-50 ml-1']) }}
                            </div>
                        </div>
                    </div>
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


@push('scripts')

    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        $(() => {
            $('#description').summernote({
                height: 300,
            });
        })

    </script>

    <script>
        $(() => {

            let container = $(`.sona-container`);
            container.on('click', '.preview-change-image', triggerUpload);
            container.on('change', '.uploader-input', previewFile);

            function triggerUpload() {
                let el = $(this);
                el.siblings('.uploader-input').trigger('click');
            }

            function previewFile() {
                let el = $(this);
                let sona = el.parents('.sona');
                let container = sona.find('.preview-image');
                let hidden = sona.find('.base-image');

                let reader = new FileReader();
                let file = el[0].files[0];

                reader.addEventListener("load", function() {  
                    container.prop('src', reader.result);
                    hidden.prop('value', reader.result);
                }, false);
                 
                if (file) {  
                    reader.readAsDataURL(file); 
                }
            }


        });

        $(() => {
            $('#description').summernote({
                fontSizes: ['8', '9', '10', '11', '12', '14', '18', '20', '24', '28', '32'],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                height: 300,
            });
        })
    </script>
@endpush