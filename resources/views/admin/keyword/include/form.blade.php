<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name"
                class="form-label @error('name') text-danger @enderror">
                Keyword
            </label>
            {{ Form::text('name', $keyword->name ?? null, [
                'class' => $errors->has('name') ? 'is-invalid form-control col-6' : 'form-control col-6'
            ]) }}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>