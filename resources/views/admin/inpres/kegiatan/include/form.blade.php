@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('Program') }}
            {{ Form::select(
                "inpres_program_id",
                $programs,
                $kegiatan->inpres_program_id ?? null,
                [
                    'placeholder' => 'Program',
                    'class' =>  'form-control',
                    'required' => true
                ]
            ) }}
        </div>
        <div class="form-group">
            <label for="name"
                class="form-label @error('name') text-danger @enderror">
                Kegiatan Inpres
            </label>
            {{ Form::text(
                'name',
                $kegiatan->name ?? null,
                [
                    'class' => $errors->has('name') ? 'is-invalid form-control col-6' : 'form-control col-6',
                    'required' => true
                ]
            ) }}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('Indikator') }}
            {{ Form::textarea(
                'indikator',
                $kegiatan->indikator ?? null,
                [
                    'class' => 'form-control', 'rows' => 4,
                    'required' => true
                ]
            ) }}
        </div>
        <div class="form-group">
            {{ Form::label('Penanggung Jawab') }}
            {{ Form::select(
                "penanggung_jawab_id",
                $kementerians,
                $kegiatan->penanggung_jawab_id ?? null,
                [
                    'placeholder' => 'Penganggung Jawab',
                    'class' =>  'form-control',
                    'required' => true
                ]
            ) }}
        </div>
        <div class="row">
            <div class="col">
                {{ Form::label('Keyword') }}
                {{ Form::select(
                    'keywords[]',
                    $keywords,
                    !empty($kegiatan->keywords) ? $kegiatan->keywords->pluck('id') : [],
                    ['class' => 'keyword-listbox', 'multiple' => 'multiple']
                ) }}
            </div>
            <div class="col">
                {{ Form::label('Instansi') }}
                {{ Form::select(
                    'instansis[]',
                    $instansis,
                    !empty($kegiatan->instansis) ? $kegiatan->instansis->pluck('id') : [],
                    ['class' => 'instansi-listbox', 'multiple' => 'multiple']
                ) }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script>
        $('.keyword-listbox').bootstrapDualListbox();
        $('.instansi-listbox').bootstrapDualListbox();
    </script>
@endpush