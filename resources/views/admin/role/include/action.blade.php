@can('update', $role)
    <a href="{{ route('admin.role.edit', ['role' => $role->id]) }}"
        class="btn btn-xs btn-success">
        Edit
    </a>
@endcan

@can('delete', $role)
    {!! Form::open([
        'route' => ['admin.role.destroy', ['role' => $role->id]],
        'onsubmit' => 'return confirm("Apakah Anda yakin ingin menghapus role ini?")',
        'style' => 'display: inline;',
        'method' => 'DELETE'
    ]) !!}
        <button type="submit" class="btn btn-xs btn-danger">
            Delete
        </button>
    {!! Form::close() !!}
@endcan