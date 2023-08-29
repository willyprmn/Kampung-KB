<div class="form-row mb-3">
    <div class="col-2">
        {{ Form::select(
            'provinsi_id',
            $provinsis,
            Auth::user()->provinsi_id ?? null,
            [
                'class' => 'form-control col',
                'placeholder' => 'Provinsi',
                Auth::user()->provinsi_id ? 'disabled' : ''
            ]
        ) }}
    </div>

    <div class="col-2">
        {{ Form::select(
            'kabupaten_id',
            $kabupatens,
            Auth::user()->kabupaten_id ?? null,
            [
                'class' => 'form-control col',
                'placeholder' => 'Kabupaten/Kota',
                Auth::user()->kabupaten_id ? 'disabled' : ''
            ]
        ) }}
    </div>

    <div class="col-2">
        {{ Form::select(
            'kecamatan_id',
            $kecamatans,
            Auth::user()->kecamatan_id ?? null,
            [
                'class' => 'form-control col',
                'placeholder' => 'Kecamatan',
                Auth::user()->kecamatan_id ? 'disabled' : ''
            ]
        ) }}
    </div>
    <div class="col-2">
        {{ Form::select(
            'desa_id',
            $desas,
            Auth::user()->desa_id ?? null,
            [
                'class' => 'form-control col',
                'placeholder' => 'Desa',
                Auth::user()->desa_id ? 'disabled' : ''
            ]
        ) }}
    </div>

    {{ $options }}

    <input id="dataTable" type="hidden" value="{{ $tableId }}">

</div>

@push('scripts')
    <script>

        $(() => {
            const tableId = $('#dataTable').val();
            const oTable = window.LaravelDataTables[tableId];
            const globalAjax = {
                type: `get`,
                dataType: 'json',
                accepts: {
                    json: 'application/json'
                },
            }

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

                if (!payload.data.provinsi_id) {
                    oTable.ajax.url(`{{ url()->current() }}`).draw();
                    return;
                }

                $.ajax({
                    url: `{{ route('kabupaten.index') }}`,
                    ...globalAjax,
                    ...payload,
                    success: response => {

                        $.each(response, (key, value) => {
                            kabupatens += `<option value=${key}>${value}</option>`;
                        });
                        $(`select[name="kabupaten_id"]`).html(kabupatens);

                        let params = $.param(payload.data);
                        oTable.ajax.url(`{{ url()->current() }}?${params}`).draw();

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

                if (!payload.data.kabupaten_id) {
                    let params = $.param({
                        provinsi_id: $(`select[name="provinsi_id"]`).find(':selected').val()
                    });
                    oTable.ajax.url(`{{ url()->current() }}?${params}`).draw();
                    return;
                }


                $.ajax({
                    url: `{{ route('kecamatan.index') }}`,
                    ...globalAjax,
                    ...payload,
                    success: response => {

                        $.each(response, (key, value) => {
                            kecamatans += `<option value=${key}>${value}</option>`;
                        });
                        $(`select[name="kecamatan_id"]`).html(kecamatans);

                        let params = $.param(payload.data);
                        oTable.ajax.url(`{{ url()->current() }}?${params}`).draw();

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
                    let params = $.param({
                        kabupaten_id: $(`select[name="kabupaten_id"]`).find(':selected').val()
                    });
                    oTable.ajax.url(`{{ url()->current() }}?${params}`).draw();
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

                        let params = $.param(payload.data);
                        oTable.ajax.url(`{{ url()->current() }}?${params}`).draw();

                    },
                    error: response => {
                        console.log(`error`, response);
                    }
                });
            });


            /** selecting desa **/
            $(`select[name="desa_id"]`).on('change', () => {

                const payload = {
                    data: {
                        desa_id: $(`select[name="desa_id"]`).find(':selected').val()
                    },
                };

                let params = $.param(payload.data);
                if (!payload.data.desa_id) {
                    params = $.param({
                        kecamatan_id: $(`select[name="kecamatan_id"]`).find(':selected').val()
                    });
                }

                oTable.ajax.url(`{{ url()->current() }}?${params}`).draw();

            });
        });
    </script>
@endpush