<h3 class="mt-4 mb-3">Profil Kependudukan</h3>
<div class="card">
    <div class="card-header">
        <div class="card-title">Jumlah Penduduk Menurut Kelompok Umur dan Jenis Kelamin</div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="col-8 col-form-label"></label>
            <div class="row col-4">
                <div class="col-6">
                    {{ Form::label('Pria') }}
                </div>
                <div class="col-6">
                    {{ Form::label('Wanita') }}
                </div>
            </div>
        </div>
        @php $index = 0 @endphp
        @foreach($ranges as $id => $name)
            <div class="form-group row">
                <label class="col-8 col-form-label">{{ $name }}</label>
                <div class="row col-4">
                    <div class="col-6">
                        {{ Form::number(
                            "penduduk_ranges[$index][jumlah]",
                            $priaRangeMap[$id]['jumlah'] ?? null,
                            ['class' => $errors->has("penduduk_ranges.$index.jumlah") ? 'form-control is-invalid' : 'form-control']
                        ) }}
                        {{ Form::hidden("penduduk_ranges[$index][jenis_kelamin]", 'P') }}
                        {{ Form::hidden("penduduk_ranges[$index][range_id]", $id) }}
                        @error("penduduk_ranges.$index.jumlah") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    @php $index++ @endphp
                    <div class="col-6">
                        {{ Form::number(
                            "penduduk_ranges[$index][jumlah]",
                            $wanitaRangeMap[$id]['jumlah'] ?? null,
                            ['class' => $errors->has("penduduk_ranges.$index.jumlah") ? 'form-control is-invalid' : 'form-control']
                        ) }}
                        {{ Form::hidden("penduduk_ranges[$index][jenis_kelamin]", 'W') }}
                        {{ Form::hidden("penduduk_ranges[$index][range_id]", $id) }}
                        @error("penduduk_ranges.$index.jumlah") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    @php $index++ @endphp
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Jumlah Profil Keluarga</div>
    </div>
    <div class="card-body">
        @foreach($keluargas as $id => $name)
            <div class="form-group row">
                <label class="col-10 col-form-label @error("keluargas.$id.jumlah") text-danger @enderror">
                    {{ $name }}
                    @error("keluargas.$id.jumlah")
                        <br>
                        <small>{{ $message }}</small>
                    @enderror
                </label>
                <div class="row col-2">
                    {{ Form::number(
                        "keluargas[$id][jumlah]",
                        $pendudukKeluargaMap[$id] ?? null,
                        ['class' => $errors->has("keluargas.$id.jumlah") ? 'form-control is-invalid' : 'form-control']
                    ) }}
                </div>
            </div>
        @endforeach
    </div>
</div>