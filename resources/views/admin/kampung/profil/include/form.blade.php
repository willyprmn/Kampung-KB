<h3 class="mt-4 mb-3">Profil Kepemilikan</h3>
<div class="card">
    <div class="card-body">

        @foreach($programs as $id => $deskripsi)
            <div class="form-group row">
                {{ Form::hidden("programs[{$id}][program_id]", $id) }}
                <label for="inputEmail3" class="col-sm-9 col-form-label @error("programs.{$id}.program_flag") text-danger @enderror">{{ $deskripsi }}</label>
                <div class="col-sm-3 icheck-container @error("programs.{$id}.program_flag") is-invalid @enderror">
                    <div class="icheck-primary d-inline">
                        {{ Form::radio(
                            "programs[{$id}][program_flag]",
                            1,
                            isset($profilProgramMap[$id]) && (bool) $profilProgramMap[$id] === true,
                            ['id' => "program_{$id}_ada"]
                        ) }}
                        <label for="program_{{ $id }}_ada">Ada</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        {{ Form::radio(
                            "programs[{$id}][program_flag]",
                            0,
                            isset($profilProgramMap[$id]) && $profilProgramMap[$id] === false,
                            ['id' => "program_{$id}_tidak"]
                        ) }}
                        <label for="program_{{ $id }}_tidak">Tidak Ada</label>
                    </div>
                </div>
                @error("programs.{$id}.program_flag")
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
    </div>
</div>

<h3 class="mt-4 mb-3">Pendukung Kampung KB</h3>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sumber Dana</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($sumberDanas as $id => $name)
            <div class="form-group col-md-4 clearfix">
                <div class="icheck-primary d-inline">
                    {{ Form::checkbox('sumber_danas[]', $id, isset($profilSumberDanaMap[$id]), ['id' => "sumber_dana_{$id}"]) }}
                    <label for="sumber_dana_{{ $id }}">{{ $name }}</label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card
    @switch(true)
        @case(!empty(old('pokja_pengurusan_flag')) && (bool) old('pokja_pengurusan_flag'))
        @case((bool) $profil->pokja_pengurusan_flag)
            @break
        @default
            collapsed-card
    @endswitch
    " id="pokja-card">
    <div class="card-header">
        <div class="card-title col-sm-9 @error('pokja_pengurusan_flag') text-danger @enderror">
            Kepengurusan/Pokja Kampung KB
            @error('pokja_pengurusan_flag')
                <br />
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="card-tools">
            <div class="icheck-primary d-inline">
                {{ Form::radio(
                    'pokja_pengurusan_flag',
                    1,
                    (bool) $profil->pokja_pengurusan_flag,
                    ['id' => 'pokja_pengurusan_flag_ada']
                ) }}
                <label for="pokja_pengurusan_flag_ada">Ada</label>
            </div>
            <div class="icheck-danger d-inline">
                {{ Form::radio(
                    'pokja_pengurusan_flag',
                    0,
                    isset($profil->pokja_pengurusan_flag) && (bool) $profil->pokja_pengurusan_flag === false,
                    ['id' => 'pokja_pengurusan_flag_tidak']
                ) }}
                <label for="pokja_pengurusan_flag_tidak">Tidak Ada</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="pokja_sk_flag"
                class="col-sm-9 col-form-label @error('pokja_sk_flag') text-danger @enderror">
                SK Pokja Kampung KB
                @error('pokja_sk_flag')
                    <br />
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </label>
            <div class="col-sm-3">
                <div class="icheck-primary d-inline">
                    {{ Form::radio(
                        'pokja_sk_flag',
                        1,
                        (bool) $profil->pokja_sk_flag,
                        ['id' => 'pokja_sk_flag_ada']
                    ) }}
                    <label for="pokja_sk_flag_ada">Ada</label>
                </div>
                <div class="icheck-danger d-inline">
                    {{ Form::radio(
                        'pokja_sk_flag',
                        0,
                        isset($profil->pokja_sk_flag) && (bool) $profil->pokja_sk_flag === false,
                        ['id' => 'pokja_sk_flag_tidak']
                    ) }}
                    <label for="pokja_sk_flag_tidak">Tidak Ada</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="pokja_pelatihan_flag"
                class="col-sm-9 col-form-label @error('pokja_pelatihan_flag') text-danger @enderror">
                Pelatihan/Sosialisasi Pengelolaan Kampung KB
                @error('pokja_pelatihan_flag')
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </label>
            <div class="col-sm-3">
                <div class="icheck-primary d-inline">
                    {{ Form::radio(
                        'pokja_pelatihan_flag',
                        1,
                        (bool) $profil->pokja_pelatihan_flag,
                        ['id' => 'pokja_pelatihan_flag_ada']
                    ) }}
                    <label for="pokja_pelatihan_flag_ada">Ada</label>
                </div>
                <div class="icheck-danger d-inline">
                    {{ Form::radio(
                        'pokja_pelatihan_flag',
                        0,
                        isset($profil->pokja_pelatihan_flag) && (bool) $profil->pokja_pelatihan_flag === false,
                        ['id' => 'pokja_pelatihan_flag_tidak']
                    ) }}
                    <label for="pokja_pelatihan_flag_tidak">Tidak Ada</label>
                </div>
            </div>
        </div>

        <div class="form-group row"
            @switch(true)
                @case(!empty(old('pokja_pelatihan_flag')) && (bool) old('pokja_pelatihan_flag')) @break
                @case((bool) $profil->pokja_pelatihan_flag) @break
                @default
                    style="display: none;"
            @endswitch
            id="pokja_pelatihan_desc_form">
            <label for="pokja_pelatihan_desc"
                class="col-sm-6 col-form-label @error('pokja_pelatihan_desc') text-danger @enderror">
                Detail Pelatihan/Sosialisasi Pengelolaan Kampung KB
            </label>
            {{ Form::text(
                'pokja_pelatihan_desc',
                $profil->pokja_pelatihan_desc,
                ['class' => $errors->has('pokja_pelatihan_desc') ? 'col-sm-6 form-control is-invalid' : 'col-sm-6 form-control']
            ) }}
            @error('pokja_pelatihan_desc')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group row">
            <label for="pokja_jumlah"
                class="col-sm-9 col-form-label @error('pokja_jumlah') text-danger @enderror">
                Jumlah Anggota Pokja Kampung KB
            </label>
            {{ Form::number(
                'pokja_jumlah',
                $profil->pokja_jumlah,
                ['class' => $errors->has('pokja_jumlah') ? 'col-sm-3 end form-control is-invalid' : 'col-sm-3 end form-control']
            ) }}
            @error('pokja_jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group row">
            <label for="pokja_jumlah_terlatih"
                class="col-sm-9 col-form-label @error('pokja_jumlah_terlatih') text-danger @enderror">
                Jumlah anggota pokja terlatih/tersosialisasi pengelolaan Kampung KB
            </label>
            {{ Form::number(
                'pokja_jumlah_terlatih',
                $profil->pokja_jumlah_terlatih,
                ['class' => $errors->has('pokja_jumlah_terlatih') ? 'col-sm-3 form-control is-invalid' : 'col-sm-3 form-control']
            ) }}
            @error('pokja_jumlah_terlatih')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title col-sm-9 @error('plkb_pendamping_flag') text-danger @enderror">
            PLKB/PKB sebagai pendamping dan pengarah kegiatan
            @error('plkb_pendamping_flag')
                <br />
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="card-tools">
            <div class="icheck-primary d-inline">
                {{ Form::radio(
                    'plkb_pendamping_flag',
                    1,
                    (bool) $profil->plkb_pendamping_flag,
                    ['id' => 'plkb_pendamping_flag_ada']
                ) }}
                <label for="plkb_pendamping_flag_ada">Ada</label>
            </div>
            <div class="icheck-danger d-inline">
                {{ Form::radio(
                    'plkb_pendamping_flag',
                    0,
                    isset($profil->plkb_pendamping_flag) && (bool) $profil->plkb_pendamping_flag === false,
                    ['id' => 'plkb_pendamping_flag_tidak']
                ) }}
                <label for="plkb_pendamping_flag_tidak">Tidak Ada</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row"
            @switch(true)
                @case(!empty(old('plkb_pendamping_flag')) && (bool) old('plkb_pendamping_flag')) @break
                @case((bool) $profil->plkb_pendamping_flag) @break
                @default
                    style="display: none;"
            @endswitch
            id="plkb_nip_form">
            <label for="plkb_nip"
                class="col-sm-8 col-form-label @error('plkb_nip') text-danger @enderror">
                NIP (Nomor Induk Pegawai)
                @error('plkb_nip')
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </label>
            {{ Form::text(
                'plkb_nip',
                $profil->plkb_nip,
                ['class' => $errors->has('plkb_nip') ? 'col-sm-4 form-control is-invalid' : 'col-sm-4 form-control']
            ) }}
        </div>

        <div class="form-group row"
            @switch(true)
                @case(!empty(old('plkb_pendamping_flag')) && (bool) old('plkb_pendamping_flag'))
                @case((bool) $profil->plkb_pendamping_flag)
                    style="display: none;"
                    @break
            @endswitch
            id="plkb_pengarah_id_form">
            <label for="plkb_pengarah_id" class="col-sm-8 col-form-label @error('plkb_pengarah_id') text-danger @endif">
                Diarahkan Oleh
                @error('plkb_pengarah_id')
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </label>
            {{ Form::select(
                'plkb_pengarah_id',
                $pengarahs,
                $profil->plkb_pengarah_id,
                [
                    'placeholder' => 'Pilih Pengarah...',
                    'class' => 'form-control col-md-4'
                ]
            ) }}
        </div>

        <div class="form-group row"
            @switch(true)
                @case(!empty(old('plkb_pendamping_flag')) && (bool) old('plkb_pendamping_flag'))
                @case((bool) $profil->plkb_pendamping_flag)
                @case(!empty(old('plkb_pengarah_id')) && (int) old('plkb_pengarah_id') !== 9)
                @case((int) $profil->plkb_pengarah_id !== 9)
                    style="display: none;"
                    @break
            @endswitch
            id="plkb_pengarah_lainnya_form">
            <label for="plkb_pengarah_lainnya"
                class="col-sm-8 col-form-label @error('plkb_pengarah_lainnya') text-danger @enderror">
                Sebutan/Jabatan Pengarah
                @error('plkb_pengarah_lainnya')
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </label>
            {{ Form::text(
                'plkb_pengarah_lainnya',
                $profil->plkb_pengarah_lainnya,
                ['class' => $errors->has('plkb_pengarah_lainnya') ? 'col-sm-4 form-control is-invalid' : 'col-sm-4 form-control']
            ) }}
        </div>

        <div class="form-group row">
            <label for="plkb_nama"
                class="col-sm-6 col-form-label @error('plkb_nama') text-danger @enderror">
                Nama
                @error('plkb_nama')
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </label>
            <div class="col-sm-6">
                {{ Form::text('plkb_nama', $profil->plkb_nama, [
                    'class' => $errors->has('plkb_nama') ? 'is-invalid form-control' : 'form-control',
                ]) }}
            </div>
        </div>

        <div class="form-group row">
            <label for="plkb_kontak"
                class="col-sm-9 col-form-label @error('plkb_kontak') text-danger @enderror">
                Kontak (No HP atau Email)
                @error('plkb_kontak')
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </label>
            <div class="col-sm-3">
                {{ Form::text('plkb_kontak', $profil->plkb_kontak, [
                    'class' => $errors->has('plkb_kontak') ? 'form-control is-invalid' : "form-control",
                ]) }}
            </div>
        </div>
    </div>
</div>

<div class="card
    @switch(true)
        @case(!empty(old('regulasi_flag')) && (bool) old('regulasi_flag'))
        @case((bool) $profil->regulasi_flag)
            @break
        @default
            collapsed-card
    @endswitch
" id="regulasi-card">
    <div class="card-header">
        <div class="card-title col-sm-9 @error('regulasi_flag') text-danger @enderror">
            Regulasi dari pemerintah daerah
            @error('regulasi_flag')
                <br>
                <small>{{ $message }}</small>
            @enderror
        </div>
        <div class="card-tools">
            <div class="icheck-primary d-inline">
                {{ Form::radio(
                    'regulasi_flag',
                    1,
                    (bool) $profil->regulasi_flag,
                    ['id' => 'regulasi_flag_ada']
                ) }}
                <label for="regulasi_flag_ada">Ada</label>
            </div>
            <div class="icheck-danger d-inline">
                {{ Form::radio(
                    'regulasi_flag',
                    0,
                    isset($profil->regulasi_flag) && (bool) $profil->regulasi_flag === false,
                    ['id' => 'regulasi_flag_tidak']
                ) }}
                <label for="regulasi_flag_tidak">Tidak Ada</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row" id="regulasi_id_form">
            <label for="regulasi_id"
                class="col-sm-7 col-form-label @error('regulasi_id') text-danger @enderror">
                Pilih Regulasi
                @error('regulasi_id')
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </label>
            {{ Form::select(
                'regulasi_id',
                $regulasis,
                $profil->regulasi_id,
                [
                    'placeholder' => 'Pilih Regulasi',
                    'class' =>  $errors->has('regulasi_id') ? 'form-control col-md-5 is-invalid' : "form-control col-md-5",
                ]
            ) }}
        </div>
    </div>
</div>

<div class="card
    @switch(true)
        @case(!empty(old('penggunaan_data_flag')) && (bool) old('penggunaan_data_flag'))
        @case((bool) $profil->penggunaan_data_flag)
            @break
        @default
            collapsed-card
    @endswitch
" id="penggunaaan-data-card">
    <div class="card-header">
        <div class="card-title col-sm-9
            @error('penggunaan_datas') text-danger @enderror
            @error('penggunaan_data_flag') text-danger @enderror
        ">
            Penggunaan data dalam perencanaan dan evaluasi kegiatan
            @error('penggunaan_datas')
                <br /><small class="text-danger">{{ $message }}</small>
            @enderror
            @error('penggunaan_data_flag')
                <br /><small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="card-tools">
            <div class="icheck-primary d-inline">
                {{ Form::radio(
                    'penggunaan_data_flag',
                    1,
                    (bool) $profil->penggunaan_data_flag,
                    ['id' => 'penggunaan_data_flag_ada']
                ) }}
                <label for="penggunaan_data_flag_ada">Ada</label>
            </div>
            <div class="icheck-danger d-inline">
                {{ Form::radio(
                    'penggunaan_data_flag',
                    0,
                    isset($profil->penggunaan_data_flag) && (bool) $profil->penggunaan_data_flag === false,
                    ['id' => 'penggunaan_data_flag_tidak']
                ) }}
                <label for="penggunaan_data_flag_tidak">Tidak Ada</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($penggunaanDatas as $id => $name)
            <div class="form-group col-md-4 clearfix">
                <div class="icheck-primary d-inline">
                    {{ Form::checkbox(
                        'penggunaan_datas[]',
                        $id,
                        isset($profilPenggunaanDataMap[$id]),
                        ['id' => "penggunaan_data_{$id}"]
                    ) }}
                    <label for="penggunaan_data_{{ $id }}">{{ $name }}</label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<h3 class="mt-4 mb-3">Mekanisme Operasional</h3>

@foreach ($operasionals as $id => $name)
    <div class="card
        @switch(true)
            @case(!empty(old("operasionals.{$id}.operasional_flag")) && (bool) old("operasionals.{$id}.operasional_flag")) @break
            @case(!empty($profilOperasionalMap[$id]['flag']) && (bool) $profilOperasionalMap[$id]['flag']) @break
            @default
                collapsed-card
        @endswitch
    " id="operasional{{ $id }}-card">
        <div class="card-header">
            <div class="card-title col-sm-9 @error("operasionals.{$id}.operasional_flag") text-danger @enderror">
                {{ $name }}
                @error("operasionals.{$id}.operasional_flag")
                    <br>
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div class="card-tools">
                <div class="icheck-primary d-inline">
                    {{ Form::radio(
                        "operasionals[$id][operasional_flag]",
                        1,
                        isset($profilOperasionalMap[$id]['flag']) && (bool) $profilOperasionalMap[$id]['flag'] === true,
                        ['id' => "operasional_{$id}_flag_ada"]
                    ) }}
                    <label for="operasional_{{ $id }}_flag_ada">Ada</label>
                </div>
                <div class="icheck-danger d-inline">
                    {{ Form::radio(
                        "operasionals[$id][operasional_flag]",
                        0,
                        isset($profilOperasionalMap[$id]['flag']) && (bool) $profilOperasionalMap[$id]['flag'] === false,
                        ['id' => "operasional_{$id}_flag_tidak"]
                    ) }}
                    <label for="operasional_{{ $id }}_flag_tidak">Tidak Ada</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="operasional_{{ $id }}_frekuensi_id"
                    class="col-sm-8 col-form-label @error("operasionals.{$id}.frekuensi_id") text-danger @enderror">
                    Frekuensi
                    @error("operasionals.{$id}.frekuensi_id")
                        <br>
                        <small>{{ $message }}</small>
                    @enderror
                </label>
                {{ Form::select(
                    "operasionals[$id][frekuensi_id]",
                    $frekuensies,
                    key($profilOperasionalMap[$id]['frekuensi']) ?? null,
                    [
                        'id' => "operasional_{$id}_frekuensi_id",
                        'placeholder' => 'Pilih Frekuensi...',
                        'class' =>  $errors->has("operasionals.{$id}.frekuensi_id") ? 'form-control col-md-4 is-invalid' : 'form-control col-md-4',
                    ]
                ) }}
            </div>
            <div class="form-group row"
                @switch(true)
                    @case(!empty(old("operasionals.{$id}.frekuensi_id")) && (int) old("operasionals.{$id}.frekuensi_id") === 4) @break
                    @case(!empty($profilOperasionalMap[$id]['frekuensi']) && (int) key($profilOperasionalMap[$id]['frekuensi']) === 4) @break
                    @default
                        style="display: none;"
                @endswitch
                id="frekuensi_lainnnya_{{ $id }}_form">
                <label for="operasional_{{ $id }}_frekuensi_lainnya"
                    class="col-sm-8 col-form-label @error("operasionals.{$id}.frekuensi_lainnya") text-danger @enderror">
                    Seberapa Sering?
                    @error("operasionals.{$id}.frekuensi_lainnya")
                        <br>
                        <small>{{ $message }}</small>
                    @enderror
                </label>
                {{ Form::text(
                    "operasionals[$id][frekuensi_lainnya]",
                    current($profilOperasionalMap[$id]['frekuensi']) ?? null,
                    [
                        'id' => "operasional_{$id}_frekuensi_lainnya",
                        'class' => $errors->has("operasionals.{$id}.frekuensi_lainnya") ? 'col-sm-4 form-control is-invalid' : 'col-sm-4 form-control'
                    ]
                ) }}
            </div>
        </div>
    </div>
    <script>
        $(() => {

            $(`#operasional_{{ $id }}_flag_ada`).on('change', () => {
                $(`#operasional{{ $id }}-card`).CardWidget('expand');
            });

            $(`#operasional_{{ $id }}_flag_tidak`).on('change', () => {
                $(`#operasional{{ $id }}-card`).CardWidget('collapse');
            });

            $(`#operasional_{{ $id }}_frekuensi_id`).on('change', () => {
                let frekuensiId = $(`#operasional_{{ $id }}_frekuensi_id`).val();
                if (frekuensiId == 4) {
                    $(`#frekuensi_lainnnya_{{ $id }}_form`).css('display', 'flex');
                } else {
                    $(`#frekuensi_lainnnya_{{ $id }}_form`).css('display', 'none');
                }
            });
        })
    </script>
@endforeach