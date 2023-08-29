<?php
namespace App\DataTables\Portal\Statistik;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilterRegional {

    public function getQueryCondition(Request $request, $aliasProvinsi, $aliasKabupaten, $aliasKecamatan, $aliasDesa){

        $tableMaster = 'new_provinsi';
        $whereMaster = "";
        $where = '';
        $groupingAlias = $aliasProvinsi;

        #provinsi
        if(request()->has('provinsi_id') && !empty(request()->provinsi_id)){
            $tableMaster = 'new_kabupaten';
            $whereMaster = "where left(a.id, 2) = '{$request->provinsi_id}'";
            $where .= " and a.provinsi_id = '{$request->provinsi_id}'";
            $groupingAlias = $aliasKabupaten;
        }
        #kabupaten
        if(request()->has('kabupaten_id') && !empty(request()->kabupaten_id)){
            $tableMaster = 'new_kecamatan';
            $whereMaster = "where left(a.id, 4) = '{$request->kabupaten_id}'";
            $where .= " and a.kabupaten_id = '{$request->kabupaten_id}'";
            $groupingAlias = $aliasKecamatan;
        }
        #kecamatan
        if(request()->has('kecamatan_id') && !empty(request()->kecamatan_id)){
            $tableMaster = 'new_desa';
            $whereMaster = "where left(a.id, 6) = '{$request->kecamatan_id}'";
            $where .= " and a.kecamatan_id = '{$request->kecamatan_id}'";
            $groupingAlias = $aliasDesa;
        }
        #desa
        if(request()->has('desa_id') && !empty(request()->desa_id)){
            $tableMaster = 'new_desa';
            $whereMaster = "where a.id = '{$request->desa_id}'";
            $where .= " and a.desa_id = '{$request->desa_id}'";
            $groupingAlias = $aliasDesa;
        }

        $whereHistory = 'and is_active is true ';
        if((request()->has('date_start') && !empty(request()->date_end)) && (request()->has('date_end') && !empty(request()->date_end))){
            $date_start = Carbon::createFromFormat('d / m / Y', $request->date_start);
            $date_end = Carbon::createFromFormat('d / m / Y', $request->date_end);
            $where .= " and a.tanggal_pencanangan between '{$date_start->format('Y-m-d')}' and '{$date_end->format('Y-m-d')}'";
            $whereHistory .= " and date_trunc('day', created_at) <= '{$date_end->format('Y-m-d')}'";
        }

        return array(
            'tableMaster' => $tableMaster,
            'whereMaster' => $whereMaster,
            'where' => $where,
            'grouping' => $groupingAlias,
            'whereHistory' => $whereHistory
        );
    }
}

?>