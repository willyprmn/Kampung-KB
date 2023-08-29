<div class="row justify-content-md-center" style="flex-wrap: nowrap;">
    <div class="col-md-auto">
        <a href="{{ route('admin.inpres-program.edit', ['inpres_program' => $program->id]) }}" class="btn btn-xs btn-success">
            Edit
        </a>
    </div>
    <div class="col-md-auto">
        {!! Form::open([
            'route' => ['admin.inpres-program.destroy', ['inpres_program' => $program->id]],
            'onsubmit' => 'return confirm("Apakah Anda yakin?")',
            'method' => 'DELETE'
        ]) !!}
            {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
        {!! Form::close() !!}
    </div>
</div>