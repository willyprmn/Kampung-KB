<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Umum</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name"
                class="form-label @error('name') text-danger @enderror">
                Nama
            </label>
            {{ Form::text(
                'name',
                $program->name ?? null,
                [
                    'class' => $errors->has('name') ? 'is-invalid form-control col-6' : 'form-control col-6'
                ]
            ) }}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="deskripsi"
                class="form-label @error('deskripsi') text-danger @enderror">
                Deskripsi
            </label>
            {{ Form::text(
                'deskripsi',
                $program->deskripsi ?? null,
                [
                    'class' => $errors->has('deskripsi') ? 'is-invalid form-control col-6' : 'form-control col-6'
                ]
            ) }}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
    </div>
</div>

