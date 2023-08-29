<?php

namespace App\DataTables\Traits;

use Auth;
use Illuminate\Database\Eloquent\Builder;

trait RegionalFilterAuth
{

    public function filterByRegion(Builder $model)
    {


        switch (true) {
            case Auth::user()->desa_id || !empty(request()->get('desa_id')) :
                $desa_id = Auth::user()->desa_id ?? request()->get('desa_id');
                request()->request->add(['desa_id' => $desa_id]);
                $model = $model->where('desa_id', $desa_id);
                break;
            case Auth::user()->kecamatan_id || !empty(request()->get('kecamatan_id')):
                $kecamatan_id = Auth::user()->kecamatan_id ?? request()->get('kecamatan_id');
                request()->request->add(['kecamatan_id' => $kecamatan_id]);
                $model = $model->where('kecamatan_id', $kecamatan_id);
                break;
            case Auth::user()->kabupaten_id || !empty(request()->get('kabupaten_id')):
                $kabupaten_id = Auth::user()->kabupaten_id ?? request()->get('kabupaten_id');
                request()->request->add(['kabupaten_id' => $kabupaten_id]);
                $model = $model->where('kabupaten_id', $kabupaten_id);
                break;
            case Auth::user()->provinsi_id || !empty(request()->get('provinsi_id')):
                $provinsi_id = Auth::user()->provinsi_id ?? request()->get('provinsi_id');
                request()->request->add(['provinsi_id' => $provinsi_id]);
                $model = $model->where('provinsi_id', $provinsi_id);
                break;
        }

        return $model;

    }
}