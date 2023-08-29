<div class="container">
    <div class="row row-cols-2 px-3 py-5" style="align-items: center;">
        <div class="col">
            <h1>{{ $kampung->nama }}</h1>
        </div>
        @can('update', $kampung)
            <div class="col">
                <a class="btn btn-success float-right" href="{{ route('admin.kampungs.edit', $kampung->id) }}">Edit Kampung KB</a>
            </div>
        @endcan
    </div>

    <div class="row row-cols-2 px-3 mb-4">
        <div class="col-7">
            <img class="img-fluid rounded" src="{{ photo($kampung->path_gambar ?? '') }}">
        </div>
        <div class="col-5">
            <h3 class="ms-2">Lokasi</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    Provinsi<span class="float-right"><strong>{{ $kampung->provinsi->name ?? '-' }}</strong></span>
                </li>
                <li class="list-group-item">
                    Kabupaten/Kota<span class="float-right"><strong>{{ $kampung->kabupaten->name ?? '-' }}</strong></span>
                </li>
                <li class="list-group-item">
                    Kecamatan<span class="float-right"><strong>{{ $kampung->kecamatan->name ?? '-' }}</strong></span>
                </li>
                <li class="list-group-item">
                    Desa<span class="float-right"><strong>{{ $kampung->desa->name ?? '-' }}</strong></span>
                </li>
              </ul>
        </div>
    </div>

    <div class="row row-cols-3 px-3 mb-5">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Tanggal Pencanangan</h6>
                    <h5 class="card-title">{{ $kampung->tanggal_pencanangan->format('d F Y') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-3 mb-5">
        <div class="col">
            <h3>Gambaran Umum</h3>
            {!! $kampung->gambaran_umum ?? 'Tidak ada' !!}
        </div>
    </div>

    <div class="row px-3 mb-5">
        <div class="col">
            <h3>Struktur Badan Pengurus</h3>
            <img class="img-fluid rounded" src="{{ photo($kampung->path_struktur ?? '') }}">
        </div>
    </div>

    <div class="row px-3 mb-5">
        <div class="col">
            <h3>Kriteria</h3>
            <div class="row my-2" style="display: inline-flex;">
                @forelse($kampung->kriterias ?? [] as $key => $kriteria)
                    <div class="col">
                        <div class="card me-3" style="width: 18rem; height: 100%;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $kriteria->name }}</h5>
                                <p class="card-text">{{ $kriteria->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <h4>Kriteria tidak tersedia</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>