<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('Sasaran') }}
            {{ Form::select(
                "inpres_sasaran_id",
                $sasarans,
                $program->inpres_sasaran_id ?? null,
                [
                    'placeholder' => 'Sasaran',
                    'class' =>  'form-control',
                    'required' => true
                ],
            ) }}
        </div>
        <div class="form-group">
            <label for="name"
                class="form-label @error('name') text-danger @enderror">
                Program Inpres
            </label>
            {{ Form::text(
                'name',
                $program->name ?? null,
                [
                    'class' => $errors->has('name') ? 'is-invalid form-control col-6' : 'form-control col-6', 
                    'required' => true
                ]
            ) }}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>