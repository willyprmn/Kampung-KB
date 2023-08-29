@extends('layouts.portal')

@section('title') {{ ucwords($kampung->nama) }} @endsection
@section('description') {{ substr(strip_tags($kampung->gambaran_umum), 0, 150) }} ... @endsection
@section('canonical', route('portal.kampung.show', [
    'kampung_id' => $kampung->id,
    'slug' => Str::slug($kampung->nama)
]))

@push('styles')
    <style>
        .exists {
            color:#0054a3;
        }
        .jumbotron {
            background-position: center;
            background-image: url('{{ photo($kampung->path_gambar) }}');
            background-size: cover;
            border-radius: 0%;
        }

        .blueline {
            width: 32px;
            height: 4px;
            background-color: #13a7e8;
            margin-left: 0px;
            margin-top: -2px;
            border: 0px;
        }

        .navigation {
            background: rgba(0, 0, 0, 0.64);
        }

        .jumbotron-light {
            color: white;
        }
        .Lokasi__Icon{
            box-sizing: border-box;
            width: 48px;
            height: 48px;
            /* padding: 8px; */
            margin: .75rem;
            background: rgba(255, 255, 255, 0.2);
            font-size: 18px;
            color: #ffffff;
            line-height: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 100%;
            margin-right: 12px;
        }

        ol.breadcrumb {
            background-color: transparent;
        }
    </style>
@endpush

@section('head')
    <link rel="preload" href="{{ photo($kampung->path_gambar) }}" as="image">
    <script src="{{ asset('js/zingchart.min.js') }}"></script>
    {{-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> --}}
@endsection

@push('analytics')
    <meta property="og:title" content="{{ ucwords($kampung->nama) }}" />
    <meta property="og:description" content="{{ substr(strip_tags($kampung->gambaran_umum), 0, 150) }} ..." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('portal.kampung.show', [
        'kampung_id' => $kampung->id,
        'slug' => Str::slug($kampung->nama)
    ]) }}" />
    <meta property="og:image" content="{{ photo($kampung->path_gambar) }}" />
    <meta property="og:site_name" content="BKKBN" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": "{{ ucwords($kampung->nama) }}",
            "url": "{{ route('portal.kampung.show', [
                'kampung_id' => $kampung->id,
                'slug' => Str::slug($kampung->nama)
            ]) }}",
            "datePublished": "{{ $kampung->tanggal_pencanangan->toIso8601String() }}",
            "image": "{{ photo($kampung->path_gambar) }}",
            "thumbnailUrl": "{{ photo($kampung->path_gambar) }}"
        }
    </script>
@endpush

<!-- Font Awesome Icons -->
<link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

@section('content')

    @php

        $themes = [
            1 => 'primary',
            2 => 'warning',
            3 => 'purple',
            4 => 'yellow',
            5 => 'danger',
        ];

        $icons = [
            1 => 'bkb-square.jpeg',
            2 => 'bkr-square.jpeg',
            3 => 'bkl-square.jpeg',
            4 => 'uppka-square.jpeg',
            5 => 'pikr-square.jpeg',
            6 => 'sekertariat.png',
            7 => 'rumahdataku-square.jpeg'
        ];
    @endphp

    <header class="container-fluid pt-md-5 pb-0 jumbotron">
        <div class="container pt-md-5 border-bottom jumbotron-light">
            <div class="row mb-5">
                <div class="col-md-8 pl-4 py-4 navigation">
                    <h3 class="fw-bold mb-3">Profil</h3>
                    <h1 class="display-5 fw-bold mb-4">{{ $kampung->nama }}</h1>
                    <a href="{{ route('portal.kampung.intervensi.index', ['kampung_id' => $kampung->id]) }}" class="btn btn-primary btn-lg" type="button">Lihat Intervensi</a>
                </div>
            </div>
            <div class="row navigation">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-auto col-3">
                            <i class="Lokasi__Icon fa fa-map-marker-alt"></i>
                        </div>
                        <div class="col ml-2">
                            <div class="row">
                                <label style="color:#0d6efd; padding-top: .75rem;">Lokasi</label>
                            </div>
                            <div class="row">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb pl-0 pt-0">
                                        <li class="breadcrumb-item pl-0 pr-2">
                                            <a>{{ $kampung->provinsi->name ?? 'null' }}</a>
                                        </li>
                                        <li class="breadcrumb-item pl-0 pr-2">
                                            <a>{{ $kampung->kabupaten->name ?? 'null' }}</a>
                                        </li>
                                        <li class="breadcrumb-item pl-0 pr-2">
                                            <a>{{ $kampung->kecamatan->name ?? 'null' }}</a>
                                        </li>
                                        <li class="breadcrumb-item pl-0 pr-2">
                                            <a>{{ $kampung->desa->name ?? 'null' }}</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-auto col-3">
                            <i class="Lokasi__Icon fa fa-calendar-alt"></i>
                        </div>
                        <div class="col">
                            <div class="row">
                                <label style="color:#0d6efd; padding-left: .75rem; padding-top: .75rem;">Tanggal Pencanangan</label>
                            </div>
                            <div class="row">
                                <a style="padding-left: .75rem;">{{ $kampung->tanggal_pencanangan->format('d F Y') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-auto col-3">
                            <i class="Lokasi__Icon fa fa-tags"></i>
                        </div>
                        <div class="col ml-2">
                            <div class="row">
                                <label style="color:#0d6efd; padding-top: .75rem;">Klasifikasi</label>
                            </div>
                            <div class="row">
                                <span class="badge
                                    @switch($classification->klasifikasi)
                                        @case('Dasar') badge-danger @break
                                        @case('Berkembang') badge-warning @break
                                        @case('Mandiri') badge-success @break
                                        @case('Berkelanjutan') badge-primary @break
                                    @endswitch
                                ">
                                    <a>{{ $classification->klasifikasi ?? '-' }}</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-auto col-3">
                            <i class="Lokasi__Icon fa fa-file"></i>
                        </div>
                        <div class="col ml-2">
                            <div class="row">
                                <label style="color:#0d6efd; padding-top: .75rem;">RKM</label>
                            </div>
                            <div class="row">
                                @if (!empty($kampung->profil->archive))
                                    <a href="{{ route('admin.archive.show', $kampung->profil->archive->id) }}"
                                        target="_blank" class="btn btn-primary btn-xs">Download</a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section>
            <div class="container">
                <div class="row py-5">
                    <div class="col">
                        <h2 class="mb-4">Gambaran Umum</h2>
                        <hr class="blueLine">
                        <?=str_replace('div', 'p', $kampung->gambaran_umum)?>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row pb-5">
                    <div class="col">
                        <h2 class="mb-4">Statistik Kampung</h2>
                        <hr class="blueLine">
                        <div class="row">
                            <div class="col-md-12">
                                <x-chart.kelompok-usia :kampung="$kampung"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <x-chart.kelompok-kegiatan :kampung="$kampung"/>
                            </div>
                        </div>

                        <x-chart.pus-kb :kampung="$kampung"/>

                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row pb-5">
                    <div class="col">
                        <h2 class="mb-4">Status Badan Pengurus</h2>
                        <hr class="blueLine">
                        <img loading="lazy" src="{{ photo($kampung->path_struktur) }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light">
            <div class="container">

                <h2 class="mb-4 pt-3 pt-md-5">Sarana dan Prasarana</h2>
                <hr class="blueLine">
                <div class="row g-5 pb-3 pb-md-5">
                    @forelse($kampung->profil->programs ?? [] as $program)
                        <div class="col-6 col-md-4 mb-3">
                            <div class="card mb-3 h-100">
                                <div class="card-body text-{{ $themes[$program->id] ?? 'secondary' }} ">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @if (!empty($icons[$program->id]))
                                                <img loading="lazy" class="card-img-top" src="{{ asset('images/' . $icons[$program->id]) }}" alt="{{ $program->deskripsi }}">
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <h5>{{ $program->name }}</h5>
                                            <p class="small text-muted">{{ $program->deskripsi }}</p>
                                            <h4>
                                                @if ($program->pivot->program_flag === true)
                                                    Ada
                                                @elseif ($program->pivot->program_flag === false)
                                                    Tidak Ada
                                                @else
                                                    Belum Diisi
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        Data belum diisi
                    @endforelse
                </div>

            </div>
        </section>

        <section>
            <div class="container">
                    <h2 class="mb-4 pt-3 mt-md-5">Dukungan Terhadap Kampung KB</h2>
                    <hr class="blueLine">
                    @if (!empty($kampung->profil))
                        <table class="table p-text table-responsive">
                        <tbody>
                            <tr>
                            <td width="50%">Sumber Dana</td>
                            <td style="font-weight:bold;">
                                @if ($kampung->profil->sumber_danas->isNotEmpty())
                                    <span class="exists">Ya,</span>
                                    @foreach($kampung->profil->sumber_danas as $key => $sumber_dana)
                                        <br>{{ $sumber_dana->name }}
                                    @endforeach
                                @else
                                    Tidak
                                @endif
                            </td>
                            </tr>
                            <tr>
                                <td>Kepengurusan/pokja KKB </td>
                                <td style="font-weight:bold;">
                                    @if ($kampung->profil->pokja_pengurusan_flag === true)
                                        <span class="exists">Ada</span>
                                    @elseif ($kampung->profil->pokja_pengurusan_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>SK pokja KKB</td>
                                <td style="font-weight:bold;">
                                    @if ($kampung->profil->pokja_sk_flag === true)
                                        <span class="exists">Ada</span>
                                    @elseif ($kampung->profil->pokja_sk_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                                </td>
                            </tr>
                            <tr>
                            <td>PLKB/PKB sebagai pendamping dan pengarah kegiatan</td>
                            <td style="font-weight:bold;">
                                    @if ($kampung->profil->plkb_pendamping_flag === true)
                                        <span class="exists">Ada,</span>
                                        <br>{{ $kampung->profil->plkb_nama }}
                                        <br>{{ $kampung->profil->plkb_nip }}
                                    @elseif ($kampung->profil->plkb_pendamping_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                            </td>
                            </tr>
                            <tr>
                            <td>Regulasi dari pemerintah daerah</td>
                            <td style="font-weight:bold;">
                                    @if ($kampung->profil->regulasi_flag === true)
                                        <span class="exists">Ada,</span>
                                        @forelse($kampung->profil->regulasis ?? [] as $key => $regulasi)
                                            <br>{{ $regulasi->name ?? 'N/A'  }}
                                        @empty
                                        @endforelse
                                    @elseif ($kampung->profil->regulasi_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                            </td>
                            </tr>
                            <tr>
                            <td>Pelatihan sosialisasi bagi Pokja KKB</td>
                            <td style="font-weight:bold;">
                                    @if ($kampung->profil->pokja_pelatihan_flag === true)
                                        <span class="exists">Ada</span>
                                    @elseif ($kampung->profil->pokja_pelatihan_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                            </td>
                            </tr>
                            <tr>
                            <td>Jumlah anggota pokja yang sudah terlatih/tersosialisasi pengelolaan KKB</td>
                            <td style="font-weight:bold;">
                                    <span class="exists colnum">{{ $kampung->profil->pokja_jumlah_terlatih ?? 0 }}</span> orang pokja terlatih<br>
                                    dari <span class="exists colnum">{{ $kampung->profil->pokja_jumlah ?? 0 }}</span> orang total pokja
                            </td>
                            </tr>
                            <tr>
                                <td>Rencana Kegiatan Masyarakat</td>
                                <td style="font-weight:bold;">
                                    @if ($kampung->profil->rencana_kerja_masyarakat_flag === true)
                                        <span class="exists">Ya</span>
                                    @elseif ($kampung->profil->rencana_kerja_masyarakat_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Penggunaan data dalam perencanaan dan evaluasi kegiatan</td>
                                <td style="font-weight:bold;">
                                    @if ($kampung->profil->penggunaan_data_flag === true)
                                        <span class="exists">Ya,</span>
                                        @foreach($kampung->profil->penggunaan_datas as $key => $penggunaan_data)
                                            <br>{{ $penggunaan_data->name }}
                                        @endforeach
                                    @elseif ($kampung->profil->penggunaan_data_flag === false)
                                        Tidak Ada
                                    @else
                                        Belum Diisi
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @else Data belum diisi @endif
            </div>
        </section>

        <section>
            <div class="container">
                <h2 class="mb-4 pt-3 mt-md-5">Mekanisme Operasional</h2>
                <hr class="blueLine"></hr>
                @if (!empty($kampung->profil))
                    <table class="table p-text table-responsive">
                    <tbody>
                        @foreach ($kampung->profil->operasionals as $key => $operasional)
                            <tr>
                                <td width="50%">{{ $operasional->name }}</td>
                                <td style="font-weight:bold;">
                                    @if($operasional->pivot->operasional_flag === true)
                                        <span class="exists">Ada,</span> Frekuensi:
                                        @if($operasional->pivot->frekuensi_id === 4)
                                            {{ $operasional->pivot->frekuensi_lainnya }}
                                        @else
                                            {{ $operasional->pivot->frekuensi->name }}
                                        @endif
                                    @elseif($operasional->pivot->operasional_flag === false)
                                    {{ 'Tidak Ada' }}
                                    @else
                                        Belum Diisi
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
                @else Data belum diisi @endif
            </div>
        </section>
    </div>
@endsection
