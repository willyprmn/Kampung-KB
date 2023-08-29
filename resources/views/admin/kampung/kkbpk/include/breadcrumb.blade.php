<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Kampung: {{ $kampung->nama }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.index') }}">
                        Manajemen Kampung
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.kampungs.show', ['kampung' => request()->route('kampung')]) }}">
                        {{ $kampung->nama }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Laporan Perkembangan</a>
                </li>
                <li class="breadcrumb-item">Perkembangan Program Bangga Kencana</li>
            </ol>
        </div>
    </div>
</div>