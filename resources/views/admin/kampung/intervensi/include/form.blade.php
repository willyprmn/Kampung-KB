@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<style>

    .hidden {
        display: none!important;
    }

    .btn-group-toggle {
        display: block!important;
    }

    .btn-group-toggle > .btn {
        margin: 0 5px!important;
        margin-bottom: 1rem!important;
    }

    .btn-group-toggle > .btn.radio {
        border-radius: .25rem!important;
    }

    .btn-group-toggle > .btn.checkbox {
        border-radius: 1rem!important;
    }

    .btn-checkbox-group {
        display: block!important;
    }


    label.checkbox > input[type="checkbox"] {
        display: none;
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
        margin-right: .5rem;
    }

    .sonas .sona {
        margin-bottom: 1rem;
    }

    .hidden {
        display: none;
    }

</style>
@endpush


<h2 class="my-4">Intervensi / Kegiatan</h2>
<div class="card">
    <div class="card-header">
        <div class="card-title">Step 1 - Ceritakan tentang kegiatan intervensi yang dilakukan.</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {{ Form::label(
                        'inpres_kegiatan_id',
                        'Kegiatan *',
                        ['class' => $errors->has('inpres_kegiatan_id') ? 'text-danger' : '']
                    ) }}
                    {{ Form::select(
                        'inpres_kegiatan_id',
                        $inpresKegiatans ?? [],
                        null,
                        [
                            'class' => ($errors->has('inpres_kegiatan_id') ? 'is-invalid ' : '') . 'form-control select2',
                            'placeholder' => 'Kegiatan',
                        ]
                    ) }}
                    @error("inpres_kegiatan_id") <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div id="form-judul" class="form-group">
                    {{ Form::label(
                        'judul',
                        'Judul Kegiatan *',
                        ['class' => $errors->has('judul') ? 'text-danger' : '']
                    ) }}
                    {{ Form::text(
                        'judul',
                        $intervensi->judul ?? null,
                        [
                            'class' => $errors->has('judul') ? 'form-control is-invalid' : 'form-control',
                            'placeholder' => 'Judul Kegiatan'
                        ]
                    ) }}
                    @error("judul") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    {{ Form::label(
                        'tanggal',
                        'Tanggal Kegiatan *',
                        ['class' => $errors->has('tanggal') ? 'text-danger' : '']
                    ) }}
                    <div class="input-group date" id="tanggal" data-target-input="nearest">
                        {{ Form::text(
                            'tanggal',
                            isset($intervensi) ? $intervensi->tanggal->format('d/m/Y') : null,
                            [
                                'class' => $errors->has('tanggal') ? 'form-control is-invalid' : 'form-control',
                                'data-target' => 'tanggal'
                            ]
                        ) }}
                        <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    @error("tanggal") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    {{ Form::label(
                        'tempat',
                        'Tempat Kegiatan *',
                        ['class' => $errors->has('tempat') ? 'text-danger' : '']
                    ) }}
                    {{ Form::text(
                        'tempat',
                        $intervensi->tempat ?? null,
                        [
                            'class' => $errors->has('tempat') ? 'form-control is-invalid' : 'form-control',
                            'placeholder' => 'Tempat Kegiatan'
                        ]
                    ) }}
                    @error("tempat") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    {{ Form::label(
                        'deskripsi',
                        'Deskripsi Kegiatan *',
                        ['class' => $errors->has('deskripsi') ? 'text-danger' : '']
                    ) }}
                    {{ Form::textarea(
                        'deskripsi',
                        $intervensi->deskripsi ?? '<p>Kegiatan ini bertujuan untuk...., yang dihadiri oleh....., <br><span style="font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 1rem;">Setelah mengikuti kegiatan ini peserta menjadi ......</span></p><p><span style="font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 1rem;">Kegiatan ini terlaksana dikarenakan usaha yang dilakukan oleh.... dalam mengadvokasi/membuat proposal/mengajak...., sehingga dengan bantuan/fasilitasi ....</span><br></p><p><span style="font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 1rem;">Kegiatan ini terlaksanan dengan antusias peserta cukup baik.</span><br></p>',
                        ['id' => 'deskripsi']
                    ) }}

                    @if(empty(old('deskripsi')) && empty($intervensi->deskripsi))
                        <small class="text-muted">* Deskripsi ini dapat diubah</small>
                    @endif

                    @error("deskripsi") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Step 2 - Tambahkan informasi lebih lanjut mengenai kegiatan yang dilakukan.</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {{ Form::label(
                        'kategori_id',
                        'Seksi Kegiatan *',
                        ['class' => $errors->has('kategori_id') ? 'text-danger' : '']
                    ) }}
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach ($kategories as $id => $name)
                            <label class="btn radio btn-outline-primary">
                                {{ Form::radio(
                                    'kategori_id',
                                    $id,
                                    isset($intervensi->kategori_id) && $intervensi->kategori_id === $id,
                                    ['id' => "kategori_id_{$id}"]
                                ) }}
                                {{ $name }}
                            </label>
                        @endforeach
                    </div>

                    <div id="kategori-lainnya" class="card hidden">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col">
                                    {{ Form::text('kategori_lainnya', null , [
                                        'class' => 'form-control',
                                        'placeholder' => 'Kategori lainnya'
                                    ]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @error("kategori_id") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    {{ Form::label(
                        'program_id',
                        'Program *',
                        ['class' => $errors->has('program_id') ? 'text-danger' : '']
                    ) }}
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach ($programs as $id => $name)
                            <label class="btn radio btn-outline-primary">
                                {{ Form::radio(
                                    'program_id',
                                    $id,
                                    isset($intervensi->program_id) && $intervensi->program_id === $id
                                ) }}
                                {{ $name }}
                            </label>
                        @endforeach
                    </div>
                    @error("program_id") <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    {{ Form::label(
                        'sasarans[]',
                        'Sasaran Kegiatan (Peserta) *',
                        ['class' => $errors->has('sasarans[]') ? 'text-danger' : '']
                    ) }}
                    <div class="btn-checkbox-group">
                        @foreach ($sasarans as $id => $name)
                            <label class="btn checkbox btn-outline-primary">
                                {{ Form::checkbox(
                                    'sasarans[]',
                                    $id,
                                    isset($intervensiSasaranMap[$id]),
                                    ['id' => "sasaran_id_{$id}"]
                                ) }}
                                {{ $name }}
                            </label>
                        @endforeach
                    </div>

                    <div id="sasaran-lainnya" class="card hidden">
                        <div id="sasaran-lainnya-container" class="card-body">
                            <div id="sasaran-lainnya-item" class="form-group row">
                                <div class="col-10">
                                    {{ Form::text('sasaran_lainnya[]', null , [
                                        'class' => 'form-control',
                                        'placeholder' => 'Sasaran Lainnya lainnya'
                                    ]) }}
                                </div>
                                <button type="button" class="btn btn-danger col-2">Hapus</button>
                            </div>
                            <div class="row col">
                                <button id="sasaran-lainnya-add" type="button" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>

                    @error("sasarans[]") <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    {{ Form::label(
                        'instansis',
                        'Instansi Pembina Kegiatan *',
                        ['class' => $errors->has('instansis') ? 'text-danger' : '']
                    ) }}
                    {{ Form::select(
                        'instansis[]',
                        $instansis,
                        isset($intervensiInstansiMap)
                            ? array_keys($intervensiInstansiMap->toArray())
                            : null,
                        [
                            'multiple' => 'multiple',
                            'class' => 'select2',
                            'data-placeholder' => 'Instansi',
                            'style' => 'width: 100%;'
                        ]
                    ) }}
                    @error("instansis") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Step 3 - Tambahkan gambar kegiatan untuk menunjukkan keseruan dari kegiatan yang dilakukan.</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-8 form-group">
                {{ Form::label(
                    'jenis_post_id',
                    'Jenis Post *',
                    ['class' => $errors->has('jenis_post_id') ? 'text-danger' : '']
                ) }}
                {{ Form::select(
                    'jenis_post_id',
                    $jenisPosts->pluck('name', 'id'),
                    $intervensi->jenis_post_id ?? null,
                    [
                        'class' => $errors->has('jenis_post_id') ? 'form-control is-invalid' : 'form-control',
                        'placeholder' => 'Jenis Post'
                    ])
                }}
                @error("jenis_post_id") <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <span id="image-form">
            <script>
                let imageFormContainer = [];
            </script>
            @foreach($jenisPosts as $keyJenisPost => $jenisPost)
                @switch($jenisPost->id)
                    @case(1)
                        <script>
                            imageFormContainer[{{ $jenisPost->id }}] = `@include('admin.kampung.intervensi.include.sebelum-sesudah')`;
                        </script>
                        @break
                    @case(2)
                        <script>
                            let gambarTypeId;
                            imageFormContainer[{{ $jenisPost->id }}] = `@include('admin.kampung.intervensi.include.kegiatan')`;
                        </script>
                        @foreach($jenisPost->intervensi_gambar_types as $keyGambarType => $gambarType)
                            <script>
                                gambarTypeId = {{ $gambarType->id }};
                            </script>
                        @endforeach
                        @break
                @endswitch
            @endforeach
        </span>
    </div>
</div>


@push('scripts')

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">

    $(`input[name="sasarans[]"]`).on('change', (event) => {

        if (event.target.checked) {
            event.target.parentElement.classList.add("active");
        } else {
            event.target.parentElement.classList.remove("active");
        }

    });

    /** handle kategori lainnya **/
    $(`input[name="kategori_id"]`).on('change', event => {
        if (event.target.checked && event.target.value == 9) {
            $(`#kategori-lainnya`).removeClass('hidden');
        } else {
            $(`#kategori-lainnya`).addClass('hidden');
        }
    });

    /** handle sasaran lainnya **/
    $(`input[name="sasarans[]"]`).on('change', event => {
        let sasarans = []
        $(`input[name="sasarans[]"]:checked`).each((key, sasaran) => {
            sasarans = [...sasarans, $(sasaran).val()]
        });

        if (sasarans.includes("9")) {
            $(`#sasaran-lainnya`).removeClass('hidden');
        } else {
            $(`#sasaran-lainnya`).addClass('hidden');
        }
    });

    /** handle add sasaran lainnya **/
    $(`#sasaran-lainnya-add`).on('click', () => {
        let item = $(`#sasaran-lainnya-item`);
        $(`#sasaran-lainnya-container`).append(item);
    })

    $('#tanggal').datetimepicker({
        format: 'L'
    });

    $(() => {
        $('#deskripsi').summernote({
            height: 300,
        });
    })

    $('.select2').select2();

    $('#inpres_kegiatan_id').on('change', (event) => {

        if (event.target.value == -1) {
            $('#form-judul').removeClass('hidden');
        } else {
            $('#form-judul').addClass('hidden');
        }
    });


    const loadingImageForm = (payload = []) => {

        let gambarKey = 0;

        let sona = $('.sona-container');
        let sonas = sona.find('.sonas-fieldset');
        let imageContainer = sona.find('.preview-image');
        let input = sona.find('.uploader-input');

        sona.on('click', '.preview-change-image', triggerUpload);
        sona.on('change', '.uploader-input', previewFile);
        sonas.on('click', '.deletesona', removeSona);
        sona.on('click', '.addnewsona', addNewSona);

        function removeSona() {
            let el = $(this);
            let parent = el.parents('.sona');
            parent.remove();
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

        function triggerUpload() {
            let el = $(this);
            el.siblings('.uploader-input').trigger('click');
        }

        function generateNewSona({
            file,
            caption,
            base64,
            type
        }) {
            let url = window.location.origin;
            let sona = `
                <div class="sona">
                    <img class="preview-image" src="${base64.value}" alt="Preview">
                    <span class="preview-details">
                        <input type="hidden" accept="image/*" class="base-image" name="${base64.name}" value="${base64.value}">
                        <input class="uploader-input hidden" type="file">
                        <input class="preview-caption" type="text" name="${caption.name}" value="${caption.value}" placeholder="Caption gambar...">
                        <input type="hidden" value="${type.value}" name="${type.name}">
                        <button type='button' class="preview-change-image btn btn-primary">Pilih Gambar</button>
                        <button class="deletesona btn btn-danger" type="button"><i class="fas fa-trash"></i></button>
                    </span>
                </div>
            `;
            return sona;
        }

        function addNewSona({
            file = null,
            caption = null,
            base64 = null,
            intervensi_gambar_type_id = null
        } = {}) {

            let sona = generateNewSona({
                file: {
                    name: `intervensi_gambars[${gambarKey}][file]`,
                    value: file,
                },
                caption: {
                    name: `intervensi_gambars[${gambarKey}][caption]`,
                    value: caption || '',
                },
                base64: {
                    name: `intervensi_gambars[${gambarKey}][base64]`,
                    value: base64  || `https://kampungkb.bkkbn.go.id/assets/images/default-intervensi.png`,
                },
                type: {
                    name: `intervensi_gambars[${gambarKey}][intervensi_gambar_type_id]`,
                    value: intervensi_gambar_type_id || gambarTypeId,
                }
            });
            sonas.append(sona);

            gambarKey++;
        }

        if (payload.length > 0) {

            console.log(payload)
            return payload.map((item, key) => {
                return addNewSona(item);
            });

        }

        return addNewSona();
    };

    $(() => {

        $(`select[name="jenis_post_id"]`).on('change', () => {

            $(`.jenis-post-container`).remove();

            let jenisPostId = $(`select[name="jenis_post_id"]`).val();
            $(`#image-form`).append(imageFormContainer[jenisPostId]);
            loadingImageForm();
        });
    });
</script>

@if(old('intervensi_gambars'))
<script>
    let payload = {!! json_encode(old('intervensi_gambars')) !!};
    let jenisPostId = parseInt({{ old('jenis_post_id') }});
    $(`#image-form`).append(imageFormContainer[jenisPostId]);
    loadingImageForm(payload)
</script>
@endif

<script>
    const globalAjax = {
        type: `get`,
        dataType: 'json',
        accepts: {
            json: 'application/json'
        },
    };
</script>
{{-- <script>


    /** handle preselect on validation error **/
    $(async () => {

        const inpresProgramId = `{{ old('inpres_program_id') ?? 'null' }}`;
        const inpresKegiatanId = `{{ old('inpres_kegiatan_id') ?? $intervensi->inpres_kegiatan_id ?? 'null' }}`;

        $(`select[name="inpres_kegiatan_id"]`).html(`<option disabled>Inpres Kegiatan</option>`);

        switch (true) {
            case inpresProgramId !== null:
                const kegiatanReponse = await $.ajax({
                    url: `{{ route('inpres-kegiatan.index') }}`,
                    ...globalAjax,
                    data: {inpres_program_id: inpresProgramId},
                });

                let kegiatans = `<option disabled>Inpres Kegiatan</option>`;
                $.each(kegiatanReponse, (key, value) => {
                    kegiatans += `<option value=${key}>${value}</option>`;
                });
                $(`select[name="inpres_kegiatan_id"]`).html(kegiatans);

            case inpresKegiatanId !== null:
                $(`select[name="inpres_kegiatan_id"]`).val(inpresKegiatanId);

        }
    });
</script> --}}
@endpush