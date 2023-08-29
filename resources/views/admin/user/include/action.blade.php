@can('update', $user)
    <a href="{{ route('admin.user.edit', ['user' => $user->id]) }}"
        class="btn btn-xs btn-success">
        Edit
    </a>
@endcan

@can('create', $user)
    {!! Form::open([
        'route' => ['admin.user.destroy', ['user' => $user->id]],
        'onsubmit' => 'return confirm("Apakah Anda yakin ingin menghapus user ini?")',
        'style' => 'display: inline;',
        'method' => 'DELETE',
    ]) !!}
        <button type="submit" class="btn btn-xs btn-danger">
            Delete
        </button>
    {!! Form::close() !!}
@endcan

@can('reset', $user)
    {!! Form::open([
        'route' => ['admin.user.reset', ['id' => $user->id]],
        'onsubmit' => 'return confirm("Apakah Anda yakin ingin reset password user ini?")',
        'method' => 'PUT',
        'style' => 'display: inline;',
    ]) !!}
        <button type="submit" class="btn btn-xs btn-warning">
            Reset Password
        </button>
    {!! Form::close() !!}
@endcan