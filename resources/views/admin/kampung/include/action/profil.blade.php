@can('view', [$profil, $kampung])
    <a href="{{ route('admin.kampungs.profil.show', [
        'kampung' => $kampung->id,
        'profil' => $profil->id
    ]) }}" class="btn btn-xs btn-info">
        Detail
    </a>
@endcan