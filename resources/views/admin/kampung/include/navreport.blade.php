<nav class="nav nav-pills flex-column flex-sm-row">
    <a href="{{ route('admin.kampungs.profil.index', request()->route('kampung')) }}"
        @if(request()->route()->getName() === 'admin.kampungs.profil.index')
            class="flex-sm-fill text-sm-center nav-link active"
            aria-current="page"
        @else
            class="flex-sm-fill text-sm-center nav-link"
        @endif
    >
        Profil Data Kampung KB
    </a>
    <a href="{{ route('admin.kampungs.penduduk.index', request()->route('kampung')) }}"
        @if(request()->route()->getName() === 'admin.kampungs.penduduk.index')
            class="flex-sm-fill text-sm-center nav-link active"
            aria-current="page"
        @else
            class="flex-sm-fill text-sm-center nav-link"
        @endif
    >
        Profil Penduduk
    </a>
    <a href="{{ route('admin.kampungs.kkbpk.index', request()->route('kampung')) }}"
        @if(request()->route()->getName() === 'admin.kampungs.kkbpk.index')
            class="flex-sm-fill text-sm-center nav-link active"
            aria-current="page"
        @else
            class="flex-sm-fill text-sm-center nav-link"
        @endif
    >
        Perkembangan Program Bangga Kencana
    </a>
</nav>