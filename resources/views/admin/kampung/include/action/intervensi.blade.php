<div class="row justify-content-md-center">
    @can('update', [$intervensi, $kampung])
        <div class="col-md-auto">
            <a href="{{ route('admin.kampungs.intervensi.edit', [
                'kampung' => $kampung->id,
                'intervensi' => $intervensi->id
            ]) }}" class="btn btn-xs btn-success">
                Edit
            </a>
        </div>
    @endcan
    @can('delete', [$intervensi, $kampung])
        <div class="col-md-auto">
            {!! Form::open([
                'route' => [
                    'admin.kampungs.intervensi.destroy', [
                        'kampung' => $kampung->id,
                        'intervensi' => $intervensi->id
                    ],
                ],
                'onsubmit' => 'return confirm("Apakah Anda yakin?")',
                'method' => 'DELETE',
            ]) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) }}
            {!! Form::close() !!}
        </div>
    @endcan
</div>