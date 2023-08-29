<div class="row justify-content-md-center" style="flex-wrap: nowrap;">
    @can('update', $instansi)
        <div class="col-md-auto">
            <a href="{{ route('admin.instansi.edit', ['instansi' => $instansi->id]) }}" class="btn btn-xs btn-success">
                Edit
            </a>
        </div>
    @endcan
    @can('delete', $instansi)
        <div class="col-md-auto">
            {!! Form::open([
                'route' => ['admin.instansi.destroy', ['instansi' => $instansi->id]],
                'onsubmit' => 'return confirm("Apakah Anda yakin?")',
                'method' => 'DELETE'
            ]) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
            {!! Form::close() !!}
        </div>
    @endcan
</div>