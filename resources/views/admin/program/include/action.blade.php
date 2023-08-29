@can('update', $program)
    <a href="{{ route('admin.program.edit', ['program' => $program->id]) }}" class="btn btn-xs btn-success">
        Edit
    </a>
@endcan

@can('delete', $program)
    {!! Form::open([
        'route' => ['admin.program.destroy', ['program' => $program->id]],
        'onsubmit' => 'return confirm("Apakah Anda yakin ingin menghapus program ini?")',
        'style' => 'display: inline;',
        'method' => 'DELETE',
    ]) !!}
        <button type="submit" class="btn btn-xs btn-danger">
            Delete
        </button>
    {!! Form::close() !!}
@endcan