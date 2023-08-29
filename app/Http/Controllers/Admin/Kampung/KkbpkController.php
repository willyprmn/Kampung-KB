<?php

namespace App\Http\Controllers\Admin\Kampung;

use DB;
use Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Kampung\KkbpkDataTable;
use App\Models\Kampung;
use App\Models\Kkbpk;
use App\Http\Requests\Admin\Kkbpk\CreateRequest;
use App\Repositories\Criteria\Penduduk\CurrentCriteria as PendudukCurrentCriteria;
use App\Repositories\Criteria\Penduduk\RangePivotCriteria as PendudukRangePivotCriteria;
use App\Repositories\Criteria\Kkbpk\Admin\ShowCriteria as KkbpkAdminShowCriteria;
use App\Repositories\Criteria\Kampung\WilayahCriteria as KampungWilayahCriteria;
use App\Repositories\Criteria\Kampung\Admin\ProfilProgramKkbpkCriteria as KampungAdminProfilProgramKkbpkCriteria;
use App\Repositories\Criteria\Kampung\Portal\MinimalCriteria as KampungCriteria;
use App\Repositories\Contract\{
    KampungRepository,
    KontrasepsiRepository,
    KkbpkRepository,
    NonKontrasepsiRepository,
    PendudukRepository,
    ProgramRepository
};

class KkbpkController extends Controller
{

    const PROGRAM_KELUARGA_MAP = [
        1 => 4,
        2 => 5,
        3 => 6,
        4 => 2,
        5 => 3,
    ];

    protected $kkbpkDataTable;
    protected $kampungRepository,
        $kontrasepsiRepository,
        $kkbpkRepository,
        $nonKontrasepsiRepository,
        $pendudukRepository,
        $programRepository
        ;

    public function __construct(
        KkbpkDataTable $kkbpkDataTable,

        KampungRepository $kampungRepository,
        KontrasepsiRepository $kontrasepsiRepository,
        KkbpkRepository $kkbpkRepository,
        NonKontrasepsiRepository $nonKontrasepsiRepository,
        PendudukRepository $pendudukRepository,
        ProgramRepository $programRepository
    ) {

        $this->kkbpkDataTable = $kkbpkDataTable;

        $this->kampungRepository = $kampungRepository;
        $this->kontrasepsiRepository = $kontrasepsiRepository;
        $this->kkbpkRepository = $kkbpkRepository;
        $this->nonKontrasepsiRepository = $nonKontrasepsiRepository;
        $this->pendudukRepository = $pendudukRepository;
        $this->programRepository = $programRepository;
    }


    public function index(Request $request, $kampungId)
    {

        if ($request->wantsJson()) {
            $kampung = Kampung::find($kampungId);
            return $this->kkbpkDataTable
                ->with('kampung', $kampung)
                ->render('admin.kampung.show');
        }

        return view('admin.kampung.kkbpk.index');
    }

    public function show(Request $request, $kampungId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Kkbpk
        $this->kkbpkRepository->pushCriteria(KkbpkAdminShowCriteria::class);
        $kkbpk = $this->kkbpkRepository
            ->findWhere([
                'kampung_kb_id' => $kampungId,
                'is_active' => true
            ])
            ->first();

        # Policy
        $this->authorize('view', [$kkbpk, $kampung]);

        # Penduduk
        $this->pendudukRepository->pushCriteria(PendudukRangePivotCriteria::class);
        $this->pendudukRepository->pushCriteria(PendudukCurrentCriteria::class);
        $penduduk = $this->pendudukRepository
            ->findWhere([
                'is_active' => true,
                'kampung_kb_id' => $kampungId
            ])
            ->first();

        $penduduk->append('jumlah_jiwa');

        $keluargaMap = $penduduk->keluargas->mapWithKeys(function ($keluarga) {
            return [$keluarga->id => [
                'jumlah' => $keluarga->pivot->jumlah,
                'name' => $keluarga->name,
            ]];
        });
        $programKeluargaMap = self::PROGRAM_KELUARGA_MAP;

        #get program group
        $programGroups = $this->programRepository->whereHas('groups', function($query){
            return $query->where('name', 'KKBPK');
        })->get();

        #get program
        $kkbpkProgramMap = $kkbpk->programs->mapWithKeys(function ($program) {
            return [$program->id => $program->pivot->jumlah];
        });

        #get kontrasepsi
        $kkbpkKontrasepsiMap = $kkbpk->kontrasepsis->mapWithKeys(function ($kontrasepsi) {
            return [$kontrasepsi->id => $kontrasepsi->pivot->jumlah];
        });

        #get non kontrasepsi
        $kkbpkNonKontrasepsiMap = $kkbpk->non_kontrasepsis->mapWithKeys(function ($nonKontrasepsi) {
            return [$nonKontrasepsi->id => $nonKontrasepsi->pivot->jumlah];
        });

        $programs = $programGroups->mapWithKeys(function ($program) use ($keluargaMap, $programKeluargaMap) {
            return [
                $program->id => [
                    'name' => $program->name,
                    'keluarga' => isset($programKeluargaMap[$program->id]) && isset($keluargaMap[$programKeluargaMap[$program->id]]) ? $keluargaMap[$programKeluargaMap[$program->id]] : null,
                ]
            ];
        });

        $kontrasepsis = $this->kontrasepsiRepository->get()->pluck('name', 'id');
        $nonKontrasepsis = $this->nonKontrasepsiRepository->get()->pluck('name', 'id');

        return view('admin.kampung.kkbpk.show', compact(
            'kampung',
            'penduduk',
            'kkbpk',
            'programs',
            'kontrasepsis',
            'nonKontrasepsis',
            'programKeluargaMap',
            'keluargaMap',
            'kkbpkProgramMap',
            'kkbpkKontrasepsiMap',
            'kkbpkNonKontrasepsiMap'
        ));
    }

    public function create(Request $request, $kampungId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $this->kampungRepository->pushCriteria(KampungAdminProfilProgramKkbpkCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [Kkbpk::class, $kampung]);

        # Penduduk
        $this->pendudukRepository->pushCriteria(PendudukRangePivotCriteria::class);
        $this->pendudukRepository->pushCriteria(PendudukCurrentCriteria::class);
        $penduduk = $this->pendudukRepository
            ->findWhere([
                'is_active' => true,
                'kampung_kb_id' => $kampungId
            ])
            ->first();

        # Handler empty pendiuduk
        if (empty($penduduk)) {
            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', [
                    'variant' => 'danger',
                    'title' => 'Error.',
                    'message' => 'Update Perkembangan Program Bangga Kencana belum dapat dilakukan, silahkan lakukan update data Penduduk terlebih dahulu.'
                ]);
        }
        $penduduk->append('jumlah_jiwa');

        $keluargaMap = $penduduk->keluargas->mapWithKeys(function ($keluarga) {
            return [$keluarga->id => [
                'jumlah' => $keluarga->pivot->jumlah,
                'name' => $keluarga->name,
            ]];
        });
        $programKeluargaMap = self::PROGRAM_KELUARGA_MAP;
        $this->kkbpkRepository->pushCriteria(KkbpkAdminShowCriteria::class);
        $kkbpk = $this->kkbpkRepository
            ->findWhere([
                'kampung_kb_id' => $kampungId,
                'is_active' => true
            ])
            ->first();

        #get program group
        $programGroups = $this->programRepository->whereHas('groups', function($query){
            return $query->where('name', 'KKBPK');
        })->get();

        /**
         * Map program flag from poktan
         */
        $profilProgramMap = $kampung->profil->programs->pluck('pivot.program_flag', 'id');

        switch(true){

            case !empty($kkbpk) :
                #get program
                $kkbpkProgramMap = $kkbpk->programs->mapWithKeys(function ($program) use ($profilProgramMap) {
                    return [$program->id => $profilProgramMap[$program->id] ? $program->pivot->jumlah : 0];
                });

                #get kontrasepsi
                $kkbpkKontrasepsiMap = $kkbpk->kontrasepsis->mapWithKeys(function ($kontrasepsi) {
                    return [$kontrasepsi->id => $kontrasepsi->pivot->jumlah];
                });

                #get non kontrasepsi
                $kkbpkNonKontrasepsiMap = $kkbpk->non_kontrasepsis->mapWithKeys(function ($nonKontrasepsi) {
                    return [$nonKontrasepsi->id => $nonKontrasepsi->pivot->jumlah];
                });
                break;

            case empty($kkbpk) :
                #set value null from program group
                $kkbpkProgramMap = $programGroups->mapWithKeys(function ($program) use ($profilProgramMap) {
                    return [$program->id => $profilProgramMap[$program->id] ? null : 0];
                });

                #set value null kontrasepsi
                $kkbpkKontrasepsiMap = $this->kontrasepsiRepository->get()->mapWithKeys(function ($kontrasepsi) {
                    return [$kontrasepsi->id => null];
                });

                #set value null non kontrasepsi
                $kkbpkNonKontrasepsiMap = $this->nonKontrasepsiRepository->get()->mapWithKeys(function ($nonKontrasepsi) {
                    return [$nonKontrasepsi->id => null];
                });

                break;
        }

        $programs = $programGroups->mapWithKeys(function ($program) use ($keluargaMap, $profilProgramMap, $programKeluargaMap) {
            return [
                $program->id => [
                    'name' => $program->name,
                    'profil_flag' => $profilProgramMap[$program->id],
                    'keluarga' => isset($programKeluargaMap[$program->id]) && isset($keluargaMap[$programKeluargaMap[$program->id]])
                        ? $keluargaMap[$programKeluargaMap[$program->id]]
                        : null,
                ]
            ];
        });

        $kontrasepsis = $this->kontrasepsiRepository->get()->pluck('name', 'id');
        $nonKontrasepsis = $this->nonKontrasepsiRepository->get()->pluck('name', 'id');

        return view('admin.kampung.kkbpk.edit', compact(
            'kampung',
            'penduduk',
            'kkbpk',
            'programs',
            'kontrasepsis',
            'nonKontrasepsis',
            'programKeluargaMap',
            'keluargaMap',
            'kkbpkProgramMap',
            'kkbpkKontrasepsiMap',
            'kkbpkNonKontrasepsiMap'
        ));
    }


    public function store(CreateRequest $request, $kampungId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [Kkbpk::class, $kampung]);

        $input = $request
            ->merge([
                'kampung_kb_id' => $kampungId,
                'is_active' => true,
                'bulan' => now()->month,
                'tahun' => now()->year,
                ])
            ->all();

        DB::beginTransaction();

        try {

            # Set other penduduk as inactive
            DB::table(Kkbpk::getTableName())
                ->where('kampung_kb_id', $kampungId)
                ->update(['is_active' => null]);
                ;

            # Insert new penduduk
            $kkbpk = $this->kkbpkRepository->create($input);

            # Insert programs pivot
            $kkbpk->programs()->attach($input['programs']);

            # Insert kontrasepsi pivot
            $kkbpk->kontrasepsis()->attach($input['kontrasepsis']);

            # Insert non kontrasepsi pivot
            $kkbpk->non_kontrasepsis()->attach($input['non_kontrasepsis']);

            DB::commit();

            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Laporan perkembangan KKBPK kampung KB berhasil diperbaharui.'
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
}
