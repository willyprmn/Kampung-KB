<div class="row">
    @can('update', [$keyword])
    <div class="col-md-auto">
        <a href="{{ route('admin.keyword.edit', ['keyword' => $keyword->id]) }}" class="btn btn-xs btn-success">
            Edit
        </a>
    </div>
    @endcan

    @can('delete', [$keyword])
        <div class="col-md-auto">
            {!! Form::open([
                'route' => ['admin.keyword.destroy', ['keyword' => $keyword->id]],
                'onsubmit' => 'return confirm("Apakah Anda yakin?")',
                'method' => 'DELETE'
            ]) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
            {!! Form::close() !!}
        </div>
    @endcan
</div>