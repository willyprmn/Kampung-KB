@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Group Setting</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    {{ Form::label('name', 'Nama Role *') }}
                    {{ Form::text('name', $role->name ?? null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="name" class="form-label">Roles</label>
                    <select id="roles" name="roles[]" class="duallistbox" multiple="multiple">
                        @foreach($roles as $id => $name)
                            <option
                                @switch(true)
                                    @case(!empty(old("roles")) && in_array($id, old('roles'))) selected @break
                                    @case(!empty($role->children) && $role->children->contains($id)) selected @break
                                @endswitch
                                value="{{ $id }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Hak Akses Menu</div>
            </div>
            <div class="card-body">
                <div id="role-component" menus='@json($menus)' permissions='@json($permissions)'></div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script>
        $('.duallistbox').bootstrapDualListbox();
    </script>
@endpush