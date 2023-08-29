<div class="card">
    <div class="card-header">
        <div class="card-title">
            Persentase Partisipasi Keluarga dalam Poktan (Kelompok Kegiatan)
        </div>
    </div>
    <div class="card-body">
        <div id="chartKegiatan" class="Chart__Body"></div>
        @if(!empty($chart)) {{ $chart->render() }} @endif
        <br>
        <div class="p-4 mb-2 bg-light text-dark">
            <div class="row">
                <div class="col-6 col-md-3 mb-3">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-baby fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Keluarga yang Memiliki Balita</strong></h3>
                            <span class="colnum">{{ $balita }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3 mb-3">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-user-tie fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Keluarga yang Memiliki Remaja</strong></h3>
                            <span class="colnum">{{ $memiliki_remaja }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3 mb-3">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-user-alt fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Keluarga yang Memiliki Lansia</strong></h3>
                            <span class="colnum">{{ $lansia }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3 mb-3">
                    <div class='row'>
                        <div class="col-md-auto col-12">
                            <i class="fa fa-user-alt fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            <h5><strong>Jumlah Remaja</strong></h3>
                            <span class="colnum">{{ $remaja }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
