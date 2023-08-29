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

    input[type=number] {
        text-align: end!important;
    }

</style>
@endpush

@section('content-header')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Kampung: {{ $kampung->nama }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.index') }}">
                        Manajemen Kampung
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.show', ['kampung' => $kampung->id]) }}">
                        {{ $kampung->nama }}
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Laporan Perkembangan</a></li>
                <li class="breadcrumb-item">Profil Kepemilikan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')

<div class="container">
    <div id="profil-component"
        kampung="{{ $kampung->id }}"
        current="{{ url()->current() }}"
        store="{{ route('admin.kampungs.profil.store', ['kampung' => $kampung->id]) }}"
        callback="{{ route('admin.kampungs.show', ['kampung' => $kampung->id]) }}">
        <div class="card">
            <div class="overlay">
                <i class="fas fa-2x fa-sync-alt"></i>
            </div>
            <div class="card-header">
                <div class="card-title">Memuat...</div>
            </div>
            <div class="card-body">
                <p>Mengambil data dari database</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- <script defer>

    /** pokja card **/
    $(() => {

        $('#pokja_pengurusan_flag_ada').on('change', () => {
            $('#pokja-card').CardWidget('expand');
        });

        $('#pokja_pengurusan_flag_tidak').on('change', () => {
            $('#pokja-card').CardWidget('collapse');
        });

        $(`input[name="pokja_pelatihan_flag"]`).on('change', () => {
            let hasPokjaPelatihan = $(`input[name="pokja_pelatihan_flag"]:checked`).val();
            if (hasPokjaPelatihan == 1) {
                $(`#pokja_pelatihan_desc_form`).css('display', 'flex');
            } else {
                $(`#pokja_pelatihan_desc_form`).css('display', 'none');
            }
        });
    });

    /** plkb card **/
    $(() => {

        const isPengarahLainnya = () => {
            let pengarahId = $(`select[name="plkb_pengarah_id"]`).val();
            if (pengarahId == 9) {
                $(`#plkb_pengarah_lainnya_form`).css('display', 'flex');
            } else {
                $(`#plkb_pengarah_lainnya_form`).css('display', 'none');
            }
        }

        $(`input[name="plkb_pendamping_flag"]`).on('change', () => {
            let hasPlkb = $(`input[name="plkb_pendamping_flag"]:checked`).val();
            if (hasPlkb == 1) {
                $(`#plkb_nip_form`).css('display', 'flex');
                $(`#plkb_pengarah_id_form`).css('display', 'none');
                $(`#plkb_pengarah_lainnya_form`).css('display', 'none');
            } else {
                $(`#plkb_nip_form`).css('display', 'none');
                $(`#plkb_pengarah_id_form`).css('display', 'flex');
                isPengarahLainnya();
            }
        });

        $(`select[name="plkb_pengarah_id"]`).on('change', isPengarahLainnya);
    });

    /** regulasi card **/
    $(() => {

        $(`#regulasi_flag_ada`).on('change', () => {
            $('#regulasi-card').CardWidget('expand');
        });

        $(`#regulasi_flag_tidak`).on('change', () => {
            $('#regulasi-card').CardWidget('collapse');
        });
    });

    /** penggunaan data card **/
    $(() => {
        $(`#penggunaan_data_flag_ada`).on('change', () => {
            $('#penggunaaan-data-card').CardWidget('expand');
        });

        $(`#penggunaan_data_flag_tidak`).on('change', () => {
            $('#penggunaaan-data-card').CardWidget('collapse');
        });
    });

</script> --}}
@endpush