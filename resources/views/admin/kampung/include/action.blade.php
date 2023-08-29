<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <a href="{{ route('admin.kampungs.show', ['kampung' => $kampung->id]) }}" class="btn btn-xs btn-primary">
            Detail
        </a>
    </div>
    <div class="col-md-auto">
        @can('delete', $kampung)
            {!! Form::open([
                'route' => ['admin.kampungs.destroy', ['kampung' => $kampung->id] ],
                'onsubmit' => 'return confirm("Apakah Anda yakin?")',
                'method' => 'DELETE'
            ]) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
            {!! Form::close() !!}
        @endcan
    </div>
</div>