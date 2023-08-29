<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lokasi</h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="col-4 col-form-label @error('provinsi_id') text-danger @enderror">
                Provinsi
            </label>
            {{ Form::select(
                "provinsi_id",
                $provinsis,
                $provinsiId,
                [
                    'placeholder' => 'Provinsi',
                    'class' =>  $errors->has('provinsi_id') ? 'form-control col-8 is-invalid' : 'form-control col-8',
                    Auth::user()->provinsi_id ? 'readonly' : ''
                ]
            ) }}
            @error('provinsi_id')
                <small class="text-danger col-12">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label @error('kabupaten_id') text-danger @enderror">
                Kabupaten/Kota
            </label>
            {{ Form::select(
                "kabupaten_id",
                $kabupatens,
                $kabupatenId,
                [
                    'placeholder' => 'Kabupaten/Kota',
                    'class' =>  $errors->has('kabupaten_id') ? 'form-control col-8 is-invalid' : 'form-control col-8',
                    Auth::user()->kabupaten_id ? 'readonly' : ''
                ]
            ) }}
            @error('kabupaten_id')
                <small class="text-danger col-12">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label @error('kecamatan_id') text-danger @enderror">
                Kecamatan
            </label>
            {{ Form::select(
                "kecamatan_id",
                $kecamatans,
                $kecamatanId,
                [
                    'placeholder' => 'Kecamatan',
                    'class' =>  $errors->has('kecamatan_id') ? 'form-control col-8 is-invalid' : 'form-control col-8',
                    Auth::user()->kecamatan_id ? 'readonly' : ''
                ]
            ) }}
            @error('kecamatan_id')
                <small class="text-danger col-12">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label @error('desa_id') text-danger @enderror">
                Desa
            </label>
            {{ Form::select(
                "desa_id",
                $desas,
                $desaId,
                [
                    'placeholder' => 'Desa',
                    'class' =>  $errors->has('desa_id') ? 'form-control col-8 is-invalid' : 'form-control col-8',
                    Auth::user()->desa_id ? 'readonly' : ''
                ]
            ) }}
            @error('desa_id')
                <small class="text-danger col-12">{{ $message }}</small>
            @enderror
        </div>
    </div>

    {{ $footer ?? '' }}
</div>

@push('scripts')
    <script>

        const globalAjax = {
            type: `get`,
            dataType: 'json',
            accepts: {
                json: 'application/json'
            },
        };


        $(() => {

            /** selecting provinsi **/
            $(`select[name="provinsi_id"]`).on('change', () => {

                let kabupatens = `<option selected disabled>Kabupaten/Kota</option>`;
                $(`select[name="kabupaten_id"]`).html(kabupatens);

                let kecamatans = `<option selected disabled>Kecamatan</option>`;
                $(`select[name="kecamatan_id"]`).html(kecamatans);

                let desas = `<option selected disabled>Desa</option>`;
                $(`select[name="desa_id"]`).html(desas);

                const payload = {
                    data: {
                        provinsi_id: $(`select[name="provinsi_id"]`).find(':selected').val()
                    },
                };

                $.ajax({
                    url: `{{ route('kabupaten.index') }}`,
                    ...globalAjax,
                    ...payload,
                    success: response => {
                        $.each(response, (key, value) => {
                            kabupatens += `<option value=${key}>${value}</option>`;
                        });

                        $(`select[name="kabupaten_id"]`).html(kabupatens);
                    },
                    error: response => {
                        console.log(`error`, response);
                    }
                });
            });

            /** selecting kabupaten **/
            $(`select[name="kabupaten_id"]`).on('change', () => {


                let kecamatans = `<option selected disabled>Kecamatan</option>`;
                $(`select[name="kecamatan_id"]`).html(kecamatans);

                let desas = `<option selected disabled>Desa</option>`;
                $(`select[name="desa_id"]`).html(desas);

                const payload = {
                    data: {
                        kabupaten_id: $(`select[name="kabupaten_id"]`).find(':selected').val()
                    },
                };

                if (!payload.data.kabupaten_id)  return;

                $.ajax({
                    url: `{{ route('kecamatan.index') }}`,
                    ...globalAjax,
                    ...payload,
                    success: response => {
                        $.each(response, (key, value) => {
                            kecamatans += `<option value=${key}>${value}</option>`;
                        });

                        $(`select[name="kecamatan_id"]`).html(kecamatans);
                    },
                    error: response => {
                        console.log(`error`, response);
                    }
                });
            });


            /** selecting kecamatan **/
            $(`select[name="kecamatan_id"]`).on('change', () => {

                let desas = `<option selected disabled>Desa</option>`;
                $(`select[name="desa_id"]`).html(desas);

                const payload = {
                    data: {
                        kecamatan_id: $(`select[name="kecamatan_id"]`).find(':selected').val()
                    },
                };

                if (!payload.data.kecamatan_id) {
                    return;
                }

                $.ajax({
                    url: `{{ route('desa.index') }}`,
                    ...globalAjax,
                    ...payload,
                    success: response => {
                        $.each(response, (key, value) => {
                            desas += `<option value=${key}>${value}</option>`;
                        });

                        $(`select[name="desa_id"]`).html(desas);

                    },
                    error: response => {
                        console.log(`error`, response);
                    }
                })
            });


            /** selecting desa **/
            $(`select[name="desa_id"]`).on('change', () => {

                const payload = {
                    data: {
                        desa_id: $(`select[name="desa_id"]`).find(':selected').val()
                    },
                };
            });
        })
    </script>
@endpush