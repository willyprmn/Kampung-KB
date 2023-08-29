<?php

namespace App\Http\Controllers\Admin\Kampung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Kampung\{
    ProgressStatisticDataTable,
};
class ProgressStatisticController extends Controller
{
    protected $dataTable;
    public function __construct(ProgressStatisticDataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    public function index(){
        return $this->dataTable->render('admin.kampung.progress-statistic.index');
    }
}
