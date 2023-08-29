<?php

namespace App\Http\Controllers\Admin\Kampung;

use DB;
use Log;

use App\Models\{
    Kampung,
    PendudukKampung
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Kampung\PendudukDataTable;
use App\Repositories\Criteria\Kampung\WilayahCriteria as KampungWilayahCriteria;
use App\Repositories\Criteria\Kampung\Portal\MinimalCriteria as KampungCriteria;
use App\Repositories\Contract\{
    KeluargaRepository,
    PendudukRepository,
    RangeRepository,
    KampungRepository,
};
use App\Http\Requests\Admin\Penduduk\CreateRequest;
use App\Repositories\Criteria\Penduduk\Admin\ShowCriteria as PendudukAdminShowCriteria;
use App\Repositories\Criteria\Penduduk\RangePivotCriteria as PendudukRangePivotCriteria;

class PendudukController extends Controller
{

    protected $pendudukDataTable;
    protected $keluargaRepository,
        $pendudukRepository,
        $rangeRepository,
        $kampungRepository;

    public function __construct(
        PendudukDataTable $pendudukDataTable,

        KeluargaRepository $keluargaRepository,
        PendudukRepository $pendudukRepository,
        RangeRepository $rangeRepository,
        KampungRepository $kampungRepository
    ) {

        $this->pendudukDataTable = $pendudukDataTable;

        $this->keluargaRepository = $keluargaRepository;
        $this->pendudukRepository = $pendudukRepository;
        $this->rangeRepository = $rangeRepository;
        $this->kampungRepository = $kampungRepository;
    }


    public function index(Request $request, $kampungId)
    {

        if ($request->wantsJson()) {
            $kampung = Kampung::find($kampungId);
            return $this->pendudukDataTable
                ->with('kampung', $kampung)
                ->render('admin.kampung.show');
        }

        return view('admin.kampung.penduduk.index');
    }


    public function create(Request $request, $kampungId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [PendudukKampung::class, $kampung]);

        $this->pendudukRepository->pushCriteria(PendudukAdminShowCriteria::class);
        $this->pendudukRepository->pushCriteria(PendudukRangePivotCriteria::class);
        $penduduk = $this->pendudukRepository->findWhere(['is_active' => true, 'kampung_kb_id' => $kampungId])->first();


        switch (true){
            case !empty($penduduk):
                #age ranges
                $priaRangeMap = $penduduk->ranges->reduce(function ($carry, $range) {
                    if ($range->pivot->jenis_kelamin === 'P') {
                        $carry[$range->id] = [
                            'jenis_kelamin' => 'P',
                            'jumlah' => $range->pivot->jumlah
                        ];
                    }
                    return $carry;
                });
                $wanitaRangeMap = $penduduk->ranges->reduce(function ($carry, $range) {
                    if ($range->pivot->jenis_kelamin === 'W') {
                        $carry[$range->id] = [
                            'jenis_kelamin' => 'W',
                            'jumlah' => $range->pivot->jumlah
                        ];
                    }
                    return $carry;
                });

                #family
                $pendudukKeluargaMap = $penduduk->keluargas->mapWithKeys(function ($keluarga, $key) {
                    return [$keluarga->id => $keluarga->pivot->jumlah];
                });

                break;
            case empty($penduduk) :
                #age ranges
                #get master
                $ranges = $this->rangeRepository->get();

                #set default value 0
                #pria
                $priaRangeMap = $ranges->reduce(function($carry, $range){
                    $carry[$range->id] = [
                        'jenis_kelamin' => 'P',
                        'jumlah' => null
                    ];
                    return $carry;
                });

                #wanita
                $wanitaRangeMap = $ranges->reduce(function($carry, $range){
                    $carry[$range->id] = [
                        'jenis_kelamin' => 'W',
                        'jumlah' => null
                    ];
                    return $carry;
                });

                #family
                #get master
                $keluargas = $this->keluargaRepository->get();

                #set default value 0
                $pendudukKeluargaMap = $keluargas->mapWithKeys(function ($keluarga, $key) {
                    return [$keluarga->id => null];
                });

                break;
        }

        $ranges = $this->rangeRepository->get()->pluck('name', 'id');
        $keluargas = $this->keluargaRepository->get()->pluck('name', 'id');

        return view('admin.kampung.penduduk.edit', compact(
            'penduduk',
            'ranges',
            'keluargas',
            'priaRangeMap',
            'wanitaRangeMap',
            'pendudukKeluargaMap',
            'kampung'
        ));
    }


    public function store(CreateRequest $request, $kampungId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [PendudukKampung::class, $kampung]);

        $input = $request
            ->merge(['kampung_kb_id' => $kampungId, 'is_active' => true])
            ->all();

        DB::beginTransaction();

        try {

            # Set other penduduk as inactive
            DB::table(PendudukKampung::getTableName())
                ->where('kampung_kb_id', $kampungId)
                ->update(['is_active' => null]);
                ;

            # Insert new penduduk
            $penduduk = $this->pendudukRepository->create($input);

            # Insert penduduk range detail
            $penduduk->penduduk_ranges()->createMany($input['penduduk_ranges']);

            # Insert penduduk keluarga pivot
            $penduduk->keluargas()->attach($input['keluargas']);

            DB::commit();

            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Laporan perkembangan kependudukan kampung KB berhasil diperbaharui.'
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


    public function show(Request $request, $kampungId, $pendudukId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Penduduk
        $this->pendudukRepository->pushCriteria(PendudukAdminShowCriteria::class);
        $this->pendudukRepository->pushCriteria(PendudukRangePivotCriteria::class);
        $penduduk = $this->pendudukRepository->find($pendudukId);

        # Policy
        $this->authorize('view', [$penduduk, $kampung]);

        $priaRangeMap = $penduduk->ranges->reduce(function ($carry, $range) {
            if ($range->pivot->jenis_kelamin === 'P') {
                $carry[$range->id] = [
                    'jenis_kelamin' => 'P',
                    'jumlah' => $range->pivot->jumlah
                ];
            }
            return $carry;
        });
        $wanitaRangeMap = $penduduk->ranges->reduce(function ($carry, $range) {
            if ($range->pivot->jenis_kelamin === 'W') {
                $carry[$range->id] = [
                    'jenis_kelamin' => 'W',
                    'jumlah' => $range->pivot->jumlah
                ];
            }
            return $carry;
        });

        $pendudukKeluargaMap = $penduduk->keluargas->mapWithKeys(function ($keluarga, $key) {
            return [$keluarga->id => $keluarga->pivot->jumlah];
        });

        $ranges = $this->rangeRepository->get()->pluck('name', 'id');
        $keluargas = $this->keluargaRepository->get()->pluck('name', 'id');

        return view('admin.kampung.penduduk.show', compact(
            'penduduk',
            'ranges',
            'keluargas',
            'priaRangeMap',
            'wanitaRangeMap',
            'pendudukKeluargaMap'
        ));
    }
}
