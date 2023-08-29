@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Umum</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name-kampung"
                class="form-label @error('name') text-danger @enderror">
                Group
            </label>
            {{ Form::text(
                'name',
                $group->name ?? null,
                [
                    'required' => 'required',
                    'class' => $errors->has('name') ? 'is-invalid form-control col-6' : 'form-control col-6'
                ]
            ) }}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="name" class="form-label">Program</label>
            <select id="programs" name="programs[]" class="duallistbox" multiple="multiple">
                @foreach($programs as $id => $name)
                    <option
                        @if(isset($group) && isset($groupProgramMap[$id]))
                            selected
                        @endif
                        value="{{ $id }}">
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script>
        $('.duallistbox').bootstrapDualListbox();

    </script>
@endpush