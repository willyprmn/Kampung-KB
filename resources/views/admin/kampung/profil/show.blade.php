@extends('layouts.admin')


@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        .icheck-container {
            padding-top: calc(.375rem + 1px)!important;
        }

        .d-inline {
            margin-right: 1rem!important;
        }

        .form-group.row {
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Kampung: {{ $profil->kampung->nama }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Manajemen Kampung</a></li>
                <li class="breadcrumb-item"><a href="#">{{ $profil->kampung->nama }}</a></li>
                <li class="breadcrumb-item"><a href="#">Laporan Perkembangan</a></li>
                <li class="breadcrumb-item">Profil Kepemilikan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
    <div id="disabled-form" class="container">
        <h3 class="mt-4 mb-3">Profil Kepemilikan</h3>
        <div class="card">
            <div class="card-body">
                @foreach($programs as $id => $deskripsi)
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-9 col-form-label">{{ $deskripsi }}</label>
                        <div class="col-sm-3 icheck-container">
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
                                {{ Form::checkbox(
                                    'sumber_danas[]',
                                    $id,
                                    isset($profilSumberDanaMap[$id]),
                                    ['id' => "sumber_dana_{$id}"]
                                ) }}
                                <label for="sumber_dana_{{ $id }}">{{ $name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card
            @switch(true)
                @case((bool) $profil->pokja_pengurusan_flag)
                    @break
                @default
                    collapsed-card
            @endswitch
            " id="pokja-card">
            <div class="card-header">
                <div class="card-title col-sm-9">
                    Kepengurusan/Pokja Kampung KB
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
                        class="col-sm-9 col-form-label">
                        SK Pokja Kampung KB
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
                    <label for="pokja_jumlah"
                        class="col-sm-9 col-form-label">
                        Jumlah Anggota Pokja Kampung KB
                    </label>
                    {{ Form::number(
                        'pokja_jumlah',
                        $profil->pokja_jumlah,
                        ['class' => 'col-sm-3 end form-control']
                    ) }}
                </div>

                <div class="form-group row">
                    <label for="pokja_pelatihan_flag" class="col-sm-9 col-form-label">
                        Pelatihan/Sosialisasi Pengelolaan Kampung KB
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

                <div class="form-group row">
                    <label for="pokja_jumlah_terlatih"
                        class="col-sm-9 col-form-label">
                        Jumlah anggota pokja terlatih/tersosialisasi pengelolaan Kampung KB
                    </label>
                    {{ Form::number(
                        'pokja_jumlah_terlatih',
                        $profil->pokja_jumlah_terlatih,
                        ['class' => 'col-sm-3 form-control']
                    ) }}
                </div>

                <div class="form-group row" id="pokja_pelatihan_desc_form">
                    <label for="pokja_pelatihan_desc"
                        class="col-sm-7 col-form-label">
                        Detail Pelatihan/Sosialisasi Pengelolaan Kampung KB
                    </label>
                    {{ Form::text(
                        'pokja_pelatihan_desc',
                        $profil->pokja_pelatihan_desc,
                        ['class' => 'col-sm-5 form-control']
                    ) }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title col-sm-9">
                    PLKB/PKB sebagai pendamping dan pengarah kegiatan
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
                        @case((bool) $profil->plkb_pendamping_flag) @break
                        @default
                            style="display: none;"
                    @endswitch
                    id="plkb_nip_form">
                    <label for="plkb_nip"
                        class="col-sm-7 col-form-label">
                        NIP (Nomor Induk Pegawai)
                    </label>
                    {{ Form::text(
                        'plkb_nip',
                        $profil->plkb_nip,
                        ['class' => 'col-sm-5 form-control']
                    ) }}
                </div>

                <div class="form-group row"
                    @switch(true)
                        @case((bool) $profil->plkb_pendamping_flag)
                            style="display: none;"
                            @break
                    @endswitch
                    id="plkb_pengarah_id_form">
                    <label for="plkb_pengarah_id" class="col-sm-7 col-form-label">
                        Diarahkan Oleh
                    </label>
                    {{ Form::select(
                        'plkb_pengarah_id',
                        $pengarahs,
                        $profil->plkb_pengarah_id,
                        [
                            'placeholder' => 'Pilih Pengarah...',
                            'class' => 'form-control col-md-5'
                        ]
                    ) }}
                </div>

                <div class="form-group row"
                    @switch(true)
                        @case((bool) $profil->plkb_pendamping_flag)
                        @case((int) $profil->plkb_pengarah_id !== 9)
                            style="display: none;"
                            @break
                    @endswitch
                    id="plkb_pengarah_lainnya_form">
                    <label for="plkb_pengarah_lainnya"
                        class="col-sm-7 col-form-label">
                        Sebutan/Jabatan Pengarah
                    </label>
                    {{ Form::text(
                        'plkb_pengarah_lainnya',
                        $profil->plkb_pengarah_lainnya,
                        ['class' => 'col-sm-5 form-control']
                    ) }}
                </div>

                <div class="form-group row">
                    <label for="plkb_nama" class="col-sm-7 col-form-label">
                        Nama
                    </label>
                    <div class="col-sm-5">
                        {{ Form::text('plkb_nama', $profil->plkb_nama, [
                            'class' => 'form-control',
                        ]) }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="plkb_kontak"
                        class="col-sm-7 col-form-label">
                        Kontak (No HP atau Email)
                    </label>
                    <div class="col-sm-5">
                        {{ Form::text('plkb_kontak', $profil->plkb_kontak, [
                            'class' => "form-control",
                        ]) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card
            @switch(true)
                @case((bool) $profil->regulasi_flag) @break
                @default
                    collapsed-card
            @endswitch
        " id="regulasi-card">
            <div class="card-header">
                <div class="card-title col-sm-9">
                    Regulasi dari pemerintah daerah
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
                <div class="form-group row">
                    @foreach ($regulasis ?? [] as $id => $regulasi)
                        <div class="form-group col-md-6 clearfix">
                            <div class="icheck-primary d-inline">
                                {{ Form::checkbox(
                                    'regulasis[]',
                                    $id,
                                    isset($profilRegulasiMap[$id]),
                                    ['id' => "regulasi_id_{$id}"]
                                ) }}
                                <label for="regulasi_id_{{ $id }}">{{ $regulasi }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card
            @switch(true)
                @case((bool) $profil->penggunaan_data_flag)
                    @break
                @default
                    collapsed-card
            @endswitch
        " id="penggunaaan-data-card">
            <div class="card-header">
                <div class="card-title col-sm-9">
                    Penggunaan data dalam perencanaan dan evaluasi kegiatan
                </div>
                <div class="card-tools">
                    <div class="icheck-primary d-inline">
                        {{ Form::radio(
                            'penggunaan_data_flag',
                            1,
                            (bool) $profil->rencana_kerja_masyarakat_flag,
                            ['id' => 'penggunaan_data_flag_ada']
                        ) }}
                        <label for="penggunaan_data_flag_ada">Ada</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        {{ Form::radio(
                            'penggunaan_data_flag',
                            0,
                            isset($profil->rencana_kerja_masyarakat_flag) && (bool) $profil->rencana_kerja_masyarakat_flag === false,
                            ['id' => 'penggunaan_data_flag_tidak']
                        ) }}
                        <label for="penggunaan_data_flag_tidak">Tidak Ada</label>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="mb-3 form-group row">
                    <label for="formFile" class="form-label col-form-label col-sm-4">File Rencana Kegiatan</label>
                    <div class="col-sm-8">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input id="beba4da0-ad74-4e88-84a7-b3ed065d6e87" name="rkm" type="file" class="custom-file-input">
                                <label class="custom-file-label" for="beba4da0-ad74-4e88-84a7-b3ed065d6e87">{{ $profil->archive->name ?? 'N/A'}}</label>
                            </div>
                            @if(isset($profil->archive->id))
                                <div class="input-group-append">
                                    <a href="{{ route('admin.archive.show', $profil->archive->id) }}" target="_blank" class="input-group-text">Download</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label class="form-label col-form-label col-sm-9">Penggunaan Data Dalam Perencanaan dan Evaluasi Kegiatan</label>
                    <div class="icheck-container col-sm-3">
                        <div class="icheck-primary d-inline">
                            <input name="penggunaan_data_flag" id="286db3cf-82bc-4c2c-833e-adc63b68dcc7-0" type="radio" @if((bool) $profil->penggunaan_data_flag) checked @endif>
                            <label for="286db3cf-82bc-4c2c-833e-adc63b68dcc7-0">Ada</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input name="penggunaan_data_flag" id="286db3cf-82bc-4c2c-833e-adc63b68dcc7-1" type="radio" @if(isset($profil->penggunaan_data_flag) && (bool) $profil->penggunaan_data_flag === false) checked @endif>
                            <label for="286db3cf-82bc-4c2c-833e-adc63b68dcc7-1">Tidak Ada</label>
                        </div>
                    </div>
                </div>

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
                    @case(!empty($profilOperasionalMap[$id]['flag']) && (bool) $profilOperasionalMap[$id]['flag']) @break
                    @default
                        collapsed-card
                @endswitch
            " id="operasional{{ $id }}-card">
                <div class="card-header">
                    <div class="card-title col-sm-9">
                        {{ $name }}
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
                            class="col-sm-8 col-form-label">
                            Frekuensi
                        </label>
                        {{ Form::select(
                            "operasionals[$id][frekuensi_id]",
                            $frekuensies,
                            key($profilOperasionalMap[$id]['frekuensi']) ?? null,
                            [
                                'id' => "operasional_{$id}_frekuensi_id",
                                'placeholder' => 'Pilih Frekuensi...',
                                'class' => 'form-control col-md-4',
                            ]
                        ) }}
                    </div>
                    <div class="form-group row"
                        @switch(true)
                            @case(!empty($profilOperasionalMap[$id]['frekuensi']) && (int) key($profilOperasionalMap[$id]['frekuensi']) === 4) @break
                            @default
                                style="display: none;"
                        @endswitch
                        id="frekuensi_lainnnya_{{ $id }}_form">
                        <label for="operasional_{{ $id }}_frekuensi_lainnya"
                            class="col-sm-8 col-form-label">
                            Seberapa Sering?
                        </label>
                        {{ Form::text(
                            "operasionals[$id][frekuensi_lainnya]",
                            current($profilOperasionalMap[$id]['frekuensi']) ?? null,
                            [
                                'id' => "operasional_{$id}_frekuensi_lainnya",
                                'class' => 'col-sm-4 form-control'
                            ]
                        ) }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        $("#disabled-form :input").attr("disabled", true);
    </script>
@endpush