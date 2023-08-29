<div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-xl-2 col-md-6 mb-2">
                {{ Form::select(
                    'provinsi_id',
                    $provinsis,
                    null,
                    [
                        'class' => 'form-control col',
                        'placeholder' => 'Provinsi',
                    ]
                ) }}
            </div>
            <div class="col-xl-2 col-md-6 mb-2">
                <select class="form-control" name="kabupaten_id">
                    <option disabled selected value="">Kabupaten/Kota</option>
                </select>
            </div>
            <div class="col-xl-2 col-md-6 mb-2">
                <select class="form-control" name="kecamatan_id">
                    <option disabled selected value="">Kecamatan</option>
                </select>
            </div>
            <div class="col-xl-2 col-md-6 mb-2">
                <select class="form-control" name="desa_id">
                    <option disabled selected value="">Desa</option>
                </select>
            </div>

            @if($searchType === 'percontohan')
                <div class="col-xl-2 col-md-6 mb-2">
                    @include('components.include.search.percontohan')
                </div>
            @elseif($searchType === 'regional')
            @else
                <div class="col-xl-4 col-md-12">
                    @include('components.include.search.date-range')
                </div>
            @endif

            <div class="col">
                <input type="button" id="cari" name="cari" class="btn btn-primary" value="Cari"/>
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

        const globalAjax = {
            type: `get`,
            dataType: 'json',
            accepts: {
                json: 'application/json'
            },
        }

        /** selecting provinsi **/
        $(`select[name="provinsi_id"]`).on('change', () => {

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
                    let kabupatens = `<option selected value="">Kabupaten/Kota</option>`;
                    if(response.data === undefined){
                        $.each(response, (key, value) => {
                            kabupatens += `<option value=${key}>${value}</option>`;
                        });
                        $(`select[name="kabupaten_id"]`).html(kabupatens);

                        let kecamatans = `<option selected value="">Kecamatan</option>`;
                        $(`select[name="kecamatan_id"]`).html(kecamatans);

                        let desas = `<option selected value="">Desa</option>`;
                        $(`select[name="desa_id"]`).html(desas);

                        let params = $.param(payload.data);
                    }
                    $(`select[name="kabupaten_id"]`).html(kabupatens);

                },
                error: response => {
                    console.log(`error`, response);
                }
            })
        });

        /** selecting kabupaten **/
        $(`select[name="kabupaten_id"]`).on('change', () => {

            const payload = {
                data: {
                    kabupaten_id: $(`select[name="kabupaten_id"]`).find(':selected').val()
                },
            };

            $.ajax({
                url: `{{ route('kecamatan.index') }}`,
                ...globalAjax,
                ...payload,
                success: response => {
                    let kecamatans = `<option selected value="">Kecamatan</option>`;
                    if(response.data === undefined){
                        $.each(response, (key, value) => {
                            kecamatans += `<option value=${key}>${value}</option>`;
                        });
                        $(`select[name="kecamatan_id"]`).html(kecamatans);

                        let desas = `<option selected value="">Desa</option>`;
                        $(`select[name="desa_id"]`).html(desas);

                        let params = $.param(payload.data);
                    }
                    $(`select[name="kecamatan_id"]`).html(kecamatans);

                },
                error: response => {
                    console.log(`error`, response);
                }
            })
        });

        /** selecting kecamatan **/
        $(`select[name="kecamatan_id"]`).on('change', () => {

            const payload = {
                data: {
                    kecamatan_id: $(`select[name="kecamatan_id"]`).find(':selected').val()
                },
            };

            $.ajax({
                url: `{{ route('desa.index') }}`,
                ...globalAjax,
                ...payload,
                success: response => {
                    let kecamatans = `<option selected value="">Desa</option>`;
                    if(response.data === undefined){
                        $.each(response, (key, value) => {
                            kecamatans += `<option value=${key}>${value}</option>`;
                        });
                        $(`select[name="desa_id"]`).html(kecamatans);

                        let params = $.param(payload.data);
                    }
                    $(`select[name="desa_id"]`).html(kecamatans);

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

            let params = $.param(payload.data);

        });



    });

    $('#date_start').datetimepicker({
        format: 'DD / MM / YYYY'
    });

    $('#date_end').datetimepicker({
        format: 'DD / MM / YYYY'
    });
</script>
@endpush