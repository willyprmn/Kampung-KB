<?php

namespace App\Http\Controllers\Admin\Kampung;

use DB;
use Log;
use Storage;

use \Mimey\MimeTypes;
use App\Services\KampungService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Archive,
    Kampung,
    ProfilKampung
};
use App\Http\Requests\Admin\Profil\CreateRequest;
use App\Repositories\Contract\{
    FrekuensiRepository,
    KampungRepository,
    OperasionalRepository,
    PenggunaanDataRepository,
    PlkbPengarahRepository,
    ProfilRepository,
    ProgramRepository,
    RegulasiRepository,
    SumberDanaRepository,
};
use App\Repositories\Criteria\Kampung\Portal\MinimalCriteria as KampungCriteria;
use App\Repositories\Criteria\Kampung\WilayahCriteria as KampungWilayahCriteria;
use App\Repositories\Criteria\Profil\Admin\ShowCriteria as ProfilAdminShowCriteria;
use App\Repositories\Criteria\Program\PoktanCriteria as ProgramPoktanKriteria;
use App\DataTables\Admin\Kampung\ProfilDataTable;

class ProfilController extends Controller
{

    protected $kampungService;
    protected $profilDataTable;
    protected $frekuensiRepository,
        $kampungRepository,
        $operasionalRepository,
        $penggunaanDataRepository,
        $plkbPengarahRepository,
        $profilRepository,
        $programRepository,
        $regulasiRepository,
        $sumberDanaRepository
        ;

    public function __construct(
        ProfilDataTable $profilDataTable,
        KampungService $kampungService,

        FrekuensiRepository $frekuensiRepository,
        KampungRepository $kampungRepository,
        OperasionalRepository $operasionalRepository,
        PenggunaanDataRepository $penggunaanDataRepository,
        PlkbPengarahRepository $plkbPengarahRepository,
        ProfilRepository $profilRepository,
        ProgramRepository $programRepository,
        RegulasiRepository $regulasiRepository,
        SumberDanaRepository $sumberDanaRepository
    ) {

        $this->profilDataTable = $profilDataTable;
        $this->kampungService = $kampungService;

        $this->frekuensiRepository = $frekuensiRepository;
        $this->kampungRepository = $kampungRepository;
        $this->operasionalRepository = $operasionalRepository;
        $this->penggunaanDataRepository = $penggunaanDataRepository;
        $this->plkbPengarahRepository = $plkbPengarahRepository;
        $this->profilRepository = $profilRepository;
        $this->programRepository = $programRepository;
        $this->regulasiRepository = $regulasiRepository;
        $this->sumberDanaRepository = $sumberDanaRepository;
    }


    public function index(Request $request, $kampungId)
    {

        if ($request->wantsJson()) {
            $kampung = Kampung::find($kampungId);
            return $this->profilDataTable
                ->with('kampung', $kampung)
                ->render('admin.kampung.show');
        }

        return view('admin.kampung.profil.index');
    }


    public function create(Request $request, $kampungId)
    {

        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [ProfilKampung::class, $kampung]);

        return view('admin.kampung.profil.create', compact('kampung'));
    }


    public function store(CreateRequest $request, $kampungId)
    {

        $this->kampungRepository->skipCache();
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [ProfilKampung::class, $kampung]);

        $input =  $request
            ->merge([
                'kampung_kb_id' => $kampungId,
                'is_active' => true,
                'bulan' => now()->month,
                'tahun' => now()->year,
            ])
            ->all();

        DB::beginTransaction();

        try {

            # Set other profile as inactive
            DB::table(ProfilKampung::getTableName())
                ->where('kampung_kb_id', $kampungId)
                ->update(['is_active' => null]);
                ;

            # Insert new profile
            $profil = $this->profilRepository->create($input);

            # Archive
            if ($archive = $this->kampungService->uploadRkm($kampungId, $request->file('rkm'))) {
                $profil->archive()->save($archive);
            }

            if (!empty($input['regulasis'])) {
                $profil->regulasis()->attach($input['regulasis']);
            }

            # Insert Program pivot
            $profil->programs()->attach($input['programs']);

            # Insert Sumber Dana pivot
            if (!empty($input['sumber_danas']))
            $profil->sumber_danas()->attach($input['sumber_danas']);

            # Insert Penggunaan Data pivot
            if (!empty($input['penggunaan_datas'])) {
                $profil->penggunaan_datas()->attach($input['penggunaan_datas']);
            }

            # Insert Mekanisme Operasional Pivot
            $profil->operasionals()->attach($input['operasionals']);

            DB::commit();

            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Laporan perkembangan profil kampung KB berhasil diperbaharui.'
                ]);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return back()
                    ->withInput()
                    ->with(['alert'], [
                        'variant' => 'danger',
                        'title' => 'Update Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]);
            }

            report($e);
        }
    }


    public function show(Request $request, $kampungId, $profilId)
    {

        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Profil
        $this->profilRepository->pushCriteria(ProfilAdminShowCriteria::class);
        $profil = $this->profilRepository->find($profilId);

        # Policy
        $this->authorize('view', [$profil, $kampung]);

        # Transformation Map
        $profilProgramMap = $profil->profil_programs->pluck('program_flag', 'program_id');
        $profilSumberDanaMap = $profil->profil_sumber_danas->pluck('sumber_dana_id', 'sumber_dana_id');
        $profilPenggunaanDataMap = $profil->penggunaan_datas->pluck('name', 'id');
        $profilRegulasiMap = $profil->profil_regulasis->pluck('regulasi_id', 'regulasi_id');
        $profilOperasionalMap = $profil->operasionals->mapWithKeys(function ($operasional) {
            return [
                $operasional->id => [
                    'flag' => $operasional->pivot->operasional_flag,
                    'frekuensi' => [
                        $operasional->pivot->frekuensi_id => $operasional->pivot->frekuensi_lainnya
                    ]
                ]
            ];
        });

        # Master Index
        $this->programRepository->pushCriteria(ProgramPoktanKriteria::class);
        $programs = $this->programRepository->get()->pluck('deskripsi', 'id');
        $sumberDanas = $this->sumberDanaRepository->get()->pluck('name', 'id');
        $pengarahs = $this->plkbPengarahRepository->get()->pluck('name', 'id');
        $regulasis = $this->regulasiRepository->get()->pluck('name', 'id');
        $operasionals = $this->operasionalRepository->get()->pluck('name', 'id');
        $frekuensies = $this->frekuensiRepository->get()->pluck('name', 'id');
        $penggunaanDatas = $this->penggunaanDataRepository->get()->pluck('name', 'id');

        if (request()->has('debug')) dd(
            $profil->toArray(),
            ['profilProgramMap' => $profilProgramMap->toArray()],
            // $pengarahs->toArray()
            $operasionals->toArray(),
            $profilOperasionalMap->toArray()
        );

        return view('admin.kampung.profil.show', compact(
            'profil',
            'sumberDanas',
            'programs',
            'pengarahs',
            'regulasis',
            'operasionals',
            'frekuensies',
            'profilProgramMap',
            'profilSumberDanaMap',
            'profilPenggunaanDataMap',
            'profilOperasionalMap',
            'profilRegulasiMap',
            'penggunaanDatas',
        ));
    }
}
