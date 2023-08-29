<div class="row">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    PUS dan Kepesertaan Ber-KB
                </div>
            </div>
            <div class="card-body">
                <div class="p-4 mb-2 bg-light text-dark">
                    <div class="row">
                        <div class="col-6">
                            <div class='row'>
                                <div class='col-auto'>
                                    <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                </div>
                                <div class="col">
                                    <h5><strong>Total</strong></h5>
                                    <span class="colnum">{{ $sumKb }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row"> --}}
                    <div id="chartKb"></div>
                    @if (!empty($chartKb))
                        {{ $chartKb->render() }}
                    @endif

                {{-- </div> --}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    PUS dan ketidaksertaan Ber-KB
                </div>
            </div>
            <div class="card-body">
                <div class="p-4 mb-2 bg-light text-dark">
                    <div class="row">
                        <div class="col-6">
                            <div class='row'>
                                <div class='col-auto'>
                                    <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                </div>
                                <div class="col">
                                    <h5><strong>Total</strong></h3>
                                    <span class="colnum">{{ $sumNonKb }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row"> --}}
                    <div id="chartNonKb"></div>
                    @if(!empty($chartNonKb))
                        {{ $chartNonKb->render() }}
                    @endif
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>