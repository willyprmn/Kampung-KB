@push('styles')

    <style>
        .bottom-icon {
            display: flex;
            align-items: flex-end;
        }
    </style>
@endpush

<h2 class="mb-2 pt-3 mt-md-5">Jumlah Kampung KB yang Melaksanakan Program:</h2>
<hr class="blueline mb-md-4">

<div class="row mt-3">
    @foreach($inprePrograms as $key => $program)
    <div class="col col-6 col-md-3 mb-3">
        <div class="card text-white bg-{{ $themes[$program->id] ?? 'secondary' }} h-100">
            <div class="card-header" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $program->deskripsi }}">
                {{ $program->alias }}
            </div>
            <div class="card-body bottom-icon">
                <h2>
                    <i class="d-none d-md-inline-block fa fa-{{ $icons[$program->id] ?? 'user-alt' }}" aria-hidden="true"></i>
                    &nbsp; <span class="colnum">{{ $program->intervensis_count }}</span>
                </h2>
            </div>
        </div>
    </div>
    @endforeach
</div>