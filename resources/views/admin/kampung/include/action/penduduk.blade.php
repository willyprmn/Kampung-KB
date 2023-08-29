@can('view', [$penduduk, $kampung])
    <a href="{{ route('admin.kampungs.penduduk.show', [
        'kampung' => $kampung->id,
        'penduduk' => $penduduk->id
    ]) }}" class="btn btn-xs btn-info">
        Detail
    </a>
@endcan