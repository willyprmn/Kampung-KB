<div class="row justify-content-md-center" style="flex-wrap: nowrap;">
    <div class="col-md-auto">
        <a href="{{ route('admin.inpres-kegiatan.edit', ['inpres_kegiatan' => $kegiatan->id]) }}" class="btn btn-xs btn-success">
            Edit
        </a>
    </div>
    <div class="col-md-auto">
        {!! Form::open([
            'route' => ['admin.inpres-kegiatan.destroy', ['inpres_kegiatan' => $kegiatan->id]],
            'onsubmit' => 'return confirm("Apakah Anda yakin?")',
            'method' => 'DELETE'
        ]) !!}
            {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
        {!! Form::close() !!}
    </div>
</div>