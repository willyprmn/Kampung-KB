{!! Form::open([
        'route' => ['admin.percontohan.update', 'percontohan' => $kampung->id],
        'method' => 'PUT'
    ]) !!}
    @if($kampung->contoh_kabupaten_flag !== true)
        <button type="submit" name="percontohan" value="kabupaten" class="btn btn-warning">Percontohan Kabupaten</button>
    @endif

    @if($kampung->contoh_kabupaten_flag === true && $kampung->contoh_provinsi_flag === null)
        <button type="submit" name="percontohan" value="provinsi" class="btn btn-primary">Percontohan Provinsi</button>
    @endif
    
    @if($kampung->contoh_kabupaten_flag === true)
        <button type="submit" name="batal" value="contoh_kabupaten_flag" class="btn btn-danger">Batal Kabupaten</button>
    @endif

    @if($kampung->contoh_provinsi_flag === true )
        <button type="submit" name="batal" value="contoh_provinsi_flag" class="btn btn-danger">Batal Provinsi</button>
    @endif
{!! Form::close() !!}

