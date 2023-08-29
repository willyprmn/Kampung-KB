<?php

namespace App\Http\Controllers\Portal;

use Cache;

use App\Http\Controllers\Controller;
use App\DataTables\Portal\KampungDataTable;
use App\Repositories\Contract\KampungRepository;
use App\Models\{
  Range
};
use Illuminate\Http\Request;
use ZingChart\PHPWrapper\ZC;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contract\{
    KkbpkRepository,
    ProfilRepository
};

class KampungController extends Controller
{

    protected $dataTable;
    protected $kampungRepository,
        $kkbpkRepository,
        $profilRepository;

    public function __construct(
        KampungDataTable $dataTable,
        KampungRepository $kampungRepository,
        KkbpkRepository $kkbpkRepository,
        ProfilRepository $profilRepository
    ) {

        $this->dataTable = $dataTable;
        $this->kampungRepository = $kampungRepository;
        $this->kkbpkRepository = $kkbpkRepository;
        $this->profilRepository = $profilRepository;
    }

    public function index(Request $request)
    {
        return $this->dataTable->render('portal.kampung.index');
    }


    public function show($id)
    {

        $kampung = $this->kampungRepository
            ->with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])
            ->find($id);

        $kampung->profil = $this->profilRepository
            ->with([
                'operasionals.pivot.frekuensi',
                'sumber_danas',
                'penggunaan_datas',
                'regulasis',
                'archive',
                'programs' => function ($program) {
                    return $program
                        ->withPivot('program_flag')
                        ->orderBy('id', 'ASC');
                },
            ])
            ->findWhere(['kampung_kb_id' => $kampung->id])
            ->first();

        $kampung->kkbpk = $this->kkbpkRepository
            ->with([
                'programs',
                'kontrasepsis',
                'non_kontrasepsis',
            ])
            ->findWhere(['kampung_kb_id' => $kampung->id])
            ->first();

        #get classification
        $request = [
            'classification' => 'kampung',
            'id' => $id,
        ];

        $key = md5(json_encode($request));
        $data = Cache::remember($key, 500, function () use($id) {

            $sql = file_get_contents(base_path('database/sql/statistik/classification/kampung.sql'));
            $sql = str_replace('{1}', $id, $sql);
            return DB::select($sql);

        });

        $classification = !empty($data) ? $data[0] : null;

        return view('portal.kampung.show', compact('kampung', 'classification'));
    }






}
