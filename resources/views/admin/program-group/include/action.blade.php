@can('update', $group)
    <a href="{{ route('admin.program-group.edit', ['program_group' => $group->id]) }}" class="btn btn-xs btn-success">
        Edit
    </a>
@endcan

@can('delete', $group)
    {!! Form::open([
        'route' => ['admin.program-group.destroy', ['program_group' => $group->id]],
        'onsubmit' => 'return confirm("Apakah Anda yakin ingin menghapus group program ini?")',
        'style' => 'display: inline;',
        'method' => 'DELETE',
    ]) !!}
        <button type="submit" class="btn btn-xs btn-danger">
            Delete
        </button>
    {!! Form::close() !!}
@endcan