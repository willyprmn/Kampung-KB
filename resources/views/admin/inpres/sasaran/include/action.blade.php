<div class="row justify-content-md-center">
    @can('update', $sasaran)
        <div class="col-md-auto">
            <a href="{{ route('admin.inpres-sasaran.edit', ['inpres_sasaran' => $sasaran->id]) }}" class="btn btn-xs btn-success">
                Edit
            </a>
        </div>
    @endcan
    @can('delete', $sasaran)
        <div class="col-md-auto">
            {!! Form::open([
                'route' => ['admin.inpres-sasaran.destroy', ['inpres_sasaran' => $sasaran->id]],
                'onsubmit' => 'return confirm("Apakah Anda yakin?")',
                'method' => 'DELETE'
            ]) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
            {!! Form::close() !!}
        </div>
    @endcan
</div>