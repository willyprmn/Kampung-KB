<div class="card">
    <div class="card-header">
        <div class="card-title">Perkembangan KKBPK</div>
    </div>
    <div class="card-body">
        @foreach($programs as $id => $program)

            @if (is_null($program['keluarga']))
                @continue
            @endif

            <div class="form-group row">
                <div class="col-md-10 @error("programs.$id.jumlah") text-danger @enderror">
                    <label class="col-form-label">Jumlah keluarga ikut {{ $program['name'] }}</label>
                    <p class="text-muted">{{ $program['keluarga']['name'] }}: <strong>{{ $program['keluarga']['jumlah'] }}</strong></p>
                </div>
                <div class="row col-2">
                    {{ Form::number(
                        "programs[$id][jumlah]",
                        $kkbpkProgramMap[$id] ?? null,
                        [
                            'class' => $errors->has("programs.$id.jumlah") ? 'form-control is-invalid' : 'form-control',
                            isset($program['profil_flag']) && $program['profil_flag'] ? '' : 'readonly',
                        ]
                    ) }}
                    {{ Form::hidden("programs[$id][max]", $program['keluarga']['jumlah']) }}
                    @error("programs.$id.jumlah") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Jumlah PUS yang menggunakan Kontrasepsi</div>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <h5><i class="icon fas fa-users"></i>{{ $keluargaMap[1]['jumlah'] }}</h5>
            Total PUS
        </div>
        @foreach($kontrasepsis as $id => $name)
            <div class="form-group row">
                <label class="col-10 col-form-label @error("kontrasepsis.$id.jumlah") text-danger @enderror">
                    PUS Menggunakan {{ $name }}
                </label>
                <div class="row col-2">
                    {{ Form::number(
                        "kontrasepsis[$id][jumlah]",
                        $kkbpkKontrasepsiMap[$id] ?? null,
                        ['class' => $errors->has("kontrasepsis.$id.jumlah") ? 'form-control is-invalid' : 'form-control']
                    ) }}
                    @error("kontrasepsis.$id.jumlah") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        @endforeach
        <div class="form-group row @error('kontrasepsis') text-danger @enderror">
            <label class="col-10 col-form-label">
                Jumlah PUS yang menggunakan kontrasepsi
            </label>
            <div class="row col-2" style="justify-content: flex-end; padding-right: 2rem;">
                @if(!empty(old('kontrasepsis')))
                    <strong>
                        {{ array_sum(array_column(old('kontrasepsis'), 'jumlah')) }}
                    </strong>
                @elseif(isset($kkbpk->kontrasepsis))
                    <strong>{{ $kkbpk->kontrasepsis->sum('pivot.jumlah') }}</strong>
                @else
                    <strong>0</strong>
                @endif
            </div>
        </div>
    </div>
    @error('kontrasepsis')
        <div class="card-footer text-danger">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Jumlah PUS yang tidak menggunakan Kontrasepsi</div>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <h5><i class="icon fas fa-users"></i>{{ $keluargaMap[1]['jumlah'] }}</h5>
            Total PUS
        </div>
        @foreach($nonKontrasepsis as $id => $name)
            <div class="form-group row">
                <label class="col-10 col-form-label @error("non_kontrasepsis.$id.jumlah") text-danger @enderror">
                    {{ $name }}
                </label>
                <div class="row col-2">
                    {{ Form::number(
                        "non_kontrasepsis[$id][jumlah]",
                        $kkbpkNonKontrasepsiMap[$id] ?? null,
                        ['class' => $errors->has("non_kontrasepsis.$id.jumlah") ? 'form-control is-invalid' : 'form-control']
                    ) }}
                    @error("non_kontrasepsis.$id.jumlah") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        @endforeach
        <div class="form-group row @error('non_kontrasepsis') text-danger @enderror">
            <label class="col-10 col-form-label">
                Jumlah PUS yang tidak menggunakan kontrasepsi
            </label>
            <div class="row col-2" style="justify-content: flex-end; padding-right: 2rem;">
                @if(!empty(old('non_kontrasepsis')))
                    <strong>
                        {{ array_sum(array_column(old('non_kontrasepsis'), 'jumlah')) }}
                    </strong>
                @elseif(isset($kkbpk->non_kontrasepsis))
                    <strong>{{ $kkbpk->non_kontrasepsis->sum('pivot.jumlah') }}</strong>
                @else
                    <strong>0</strong>
                @endif
            </div>
        </div>
    </div>
    @error('non_kontrasepsis')
        <div class="card-footer text-danger">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Lainnya</div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-10 @error("pengguna_bpjs") text-danger @enderror">
                <label class="form-label">Pengguna BPJS</label>
                <p class="text-muted">Terdapat total <strong>{{ $penduduk->jumlah_jiwa }}</strong> jiwa di kampung ini.</p>
            </div>
            <div class="row col-2">
                {{ Form::number(
                    "pengguna_bpjs",
                    $kkbpk->pengguna_bpjs ?? null,
                    ['class' => $errors->has("pengguna_bpjs") ? 'form-control is-invalid' : 'form-control']
                ) }}
                @error("pengguna_bpjs") <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>
</div>

{{ Form::hidden('jumlah_pus', $keluargaMap[1]['jumlah']) }}
{{ Form::hidden('jumlah_jiwa', $penduduk->jumlah_jiwa) }}