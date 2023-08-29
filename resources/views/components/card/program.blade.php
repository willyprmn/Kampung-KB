<h2 class="mb-2 pt-3 pt-md-5">Jumlah Kampung KB yang Memiliki Kelompok Kegiatan</h2>
<hr class="blueline mb-2 mb-md-4">

<div class="row mt-3 pb-3 pb-md-5">
    @foreach($programs as $key => $program)
        <div class="col-6 mb-3 col-md-4">
            <div class="card mb-3 h-100">
                <div class="card-body text-{{ $themes[$program->id] ?? 'secondary' }}">
                    <div class="row">
                        <div class="col-md-4">
                            @if (!empty($icons[$program->id]))
                                <img loading="lazy" class="card-img-top" src="{{ asset('images/' . $icons[$program->id]) }}" alt="{{ $program->deskripsi }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $program->name }}</h5>
                            <p class="small text-muted">{{ $program->deskripsi }}</p>
                            <h4 class="colnum">{{ $program->profils_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
