<div class="card">
    <div class="card-header">
        <div class="card-title">
            Jumlah Penduduk Menurut Kelompok Umur
        </div>
    </div>
    <div class="card-body">
        <div class="p-4 mb-2 bg-light text-dark">
            <div class="row">
                <div class="col-4">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Jumlah Jiwa</strong></h3>
                            <span class="colnum">{{ !empty($penduduk->penduduk_ranges) ? $penduduk->penduduk_ranges->sum('jumlah') : 'n/a' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Jumlah Kepala Keluarga</strong></h3>
                            @foreach($penduduk->keluargas ?? [] as $keluarga)
                                @if($keluarga->name === 'Jumlah Keluarga')
                                    <span class="colnum">{{ $keluarga->pivot->jumlah }}</span>
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Jumlah PUS</strong></h3>
                            @foreach($penduduk->keluargas ?? [] as $keluarga)
                                @if($keluarga->id === 1)
                                    <span class="colnum">{{ $keluarga->pivot->jumlah }}</span>
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="chartKelompokUsia" class="Chart__Body"></div>
    </div>
</div>

@if(!empty($chart))
    {{ $chart->render() }}
@endif
