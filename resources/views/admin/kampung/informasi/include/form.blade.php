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

<div class="row row-cols-2">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Umum</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama-kampung"
                        class="form-label @error('nama') text-danger @enderror">
                        Nama Kampung KB
                    </label>
                    {{ Form::text(
                        'nama',
                        $kampung->nama ?? null,
                        ['class' => $errors->has('nama') ? 'is-invalid form-control' : 'form-control']
                    ) }}
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label @error('tanggal_pencanangan') text-danger @enderror">
                        Tanggal Pencanangan
                    </label>
                    <div class="input-group date" id="tanggal_pencanangan" data-target-input="nearest">
                        {{ Form::text(
                            'tanggal_pencanangan',
                            isset($kampung->tanggal_pencanangan)
                                ? $kampung->tanggal_pencanangan->format('d / m / Y')
                                : null,
                            [
                                'class' => $errors->has('tanggal_pencanangan') ? 'form-control is-invalid' : 'form-control',
                                'data-target' => 'tanggal_pencanangan'
                            ]
                        ) }}
                        <div class="input-group-append" data-target="#tanggal_pencanangan" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    @error('tanggal_pencanangan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col">

        <x-form.regional-select :client="$kampung ?? null" />

    </div>
</div>

<div class="row">
    <div class="col-10">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="kriteria" class="form-label">
                        Kriteria Kampung
                    </label>
                    @foreach($kriterias as $key => $kriteria)
                        <div class="icheck-primary">
                            {{ Form::checkbox(
                                'kriterias[]',
                                $kriteria->id,
                                isset($kampungKriteriaMap[$kriteria->id]),
                                ['id' => "kriteria_{$kriteria->id}"]
                            ) }}
                            <label for="kriteria_{{ $kriteria->id }}">{{ $kriteria->name }}: {{ $kriteria->description}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Gambaran Umum</div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    {{ Form::label(
                        'gambaran_umum',
                        'Gambaran Umum Kampung KB *',
                        ['class' => $errors->has('gambaran_umum') ? 'text-danger' : '']
                    ) }}
                    {{ Form::textarea(
                        'gambaran_umum',
                        $kampung->gambaran_umum ?? null,
                        ['id' => 'gambaran_umum']
                    ) }}
                    @error("gambaran_umum") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Lampiran</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ Form::label('', 'Gambar Kampung') }}
                            <div class="sona-container">
                                <fieldset id="fieldsetKegiatan">
                                    <div class="sonas">
                                        <div class="sona">
                                            <img class="preview-image" src="
                                                @switch(true)
                                                    @case(!empty(old('gambar.base64')))
                                                        {{ old('gambar.base64') }}
                                                        @break
                                                    @case (!empty($kampung->path_gambar))
                                                        {{ photo($kampung->path_gambar) }}
                                                        @break
                                                    @default
                                                        {{ asset('images/default-intervensi.png') }}
                                                @endswitch"
                                                alt="Preview">
                                            <span class="preview-details">
                                                {{ Form::hidden(
                                                    "gambar[base64]",
                                                    old('gambar.base64'),
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
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ Form::label('', 'Struktur Kepengurusan') }}
                            <div class="sona-container">
                                <fieldset id="fieldsetKegiatan">
                                    <div class="sonas">
                                        <div class="sona">
                                            <img class="preview-image" src="
                                                @switch(true)
                                                    @case(!empty(old('pengurus.base64')))
                                                        {{ old('pengurus.base64') }}
                                                        @break
                                                    @case(!empty($kampung->path_struktur))
                                                        {{ photo($kampung->path_struktur) }}
                                                        @break
                                                    @default
                                                        {{ asset('images/default-intervensi.png') }}
                                                @endswitch"
                                                alt="Preview">
                                            <span class="preview-details">
                                                {{ Form::hidden(
                                                    "pengurus[base64]",
                                                    old('pengurus.base64'),
                                                    ['class' => 'base-image']
                                                ) }}

                                                {{ Form::file(
                                                    old('pengurus.base64'),
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
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

        $('#tanggal_pencanangan').datetimepicker({
            format: 'DD / MM / YYYY'
        });

        $(() => {
            $('#gambaran_umum').summernote({
                height: 300,
            });
        });
    </script>
@endpush