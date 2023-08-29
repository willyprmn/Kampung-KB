<a href="{{ route('portal.kampung.show', [
    'kampung_id' => $kampung->id,
    'slug' => Str::slug($kampung->nama)
    ]) }}" class="btn btn-primary">
    Profil
</a>