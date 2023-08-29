<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-tabs">
                    @foreach($kategories as $key => $kategori)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->route('kategori_id') == $kategori->id ? 'active' : '' }}"
                                href="{{ route('portal.kampung.intervensi.kategori.index', [
                                    'kampung_id' => request()->route('kampung_id'),
                                    'kategori_id' => $kategori->id,
                                ]) }}"
                                aria-current="page"
                            >
                                {{ $kategori->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</div>
