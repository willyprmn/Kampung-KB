@can('view', [$kkbpk, $kampung])
    <a href="{{ route('admin.kampungs.kkbpk.show', [
        'kampung' => $kampung->id,
        'kkbpk' => $kkbpk->id
    ]) }}" class="btn btn-xs btn-info">
        Detail
    </a>
@endcan