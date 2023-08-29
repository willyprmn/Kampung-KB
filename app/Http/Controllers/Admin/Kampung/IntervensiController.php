<?php

namespace App\Http\Controllers\Admin\Kampung;

use DB;
use Log;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Kampung\IntervensiDataTable;
use App\Repositories\Criteria\Intervensi\Admin\ShowCriteria as IntervensiAdminShowCriteria;
use App\Repositories\Criteria\Program\IntervensiCriteria as ProgramIntervensiCriteria;
use App\Repositories\Criteria\Kampung\WilayahCriteria as KampungWilayahCriteria;
use App\Repositories\Criteria\Kampung\Portal\MinimalCriteria as KampungCriteria;
use App\Http\Requests\Admin\Intervensi\{CreateRequest, UpdateRequest};
use App\Models\Intervensi;
use App\Models\Kampung;
use App\Repositories\Contract\{
    InpresKegiatanRepository,
    InstansiRepository,
    IntervensiRepository,
    JenisPostRepository,
    KampungRepository,
    KategoriRepository,
    ProgramRepository,
    SasaranRepository
};
use App\Services\KampungService;

class IntervensiController extends Controller
{

    protected $dataTable;
    protected $inpresKegiatanRepository,
        $instansiRepository,
        $intervensiRepository,
        $jenisPostRepository,
        $kampungRepository,
        $kategoriRepository,
        $programRepository,
        $sasaranRepository
        ;

    protected $kampungService;

    public function __construct(
        IntervensiDataTable $dataTable,

        InpresKegiatanRepository $inpresKegiatanRepository,
        InstansiRepository $instansiRepository,
        IntervensiRepository $intervensiRepository,
        JenisPostRepository $jenisPostRepository,
        KampungRepository $kampungRepository,
        KategoriRepository $kategoriRepository,
        ProgramRepository $programRepository,
        SasaranRepository $sasaranRepository,

        KampungService $kampungService
    ) {

        $this->dataTable = $dataTable;

        $this->inpresKegiatanRepository = $inpresKegiatanRepository;
        $this->instansiRepository = $instansiRepository;
        $this->intervensiRepository = $intervensiRepository;
        $this->jenisPostRepository = $jenisPostRepository;
        $this->kampungRepository = $kampungRepository;
        $this->kategoriRepository = $kategoriRepository;
        $this->programRepository = $programRepository;
        $this->sasaranRepository = $sasaranRepository;

        $this->kampungService = $kampungService;
    }


    public function index(Request $request, IntervensiDataTable $intervensiDataTable, $kampungId)
    {

        if ($request->wantsJson()) {
            $kampung = Kampung::find($kampungId);
            return $intervensiDataTable
                ->with('kampung', $kampung)
                ->render('admin.kampung.show');
        }

        return view('admin.kampung.intervensi.index');
    }


    public function create(Request $request, $kampungId)
    {

        # Kampung
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [Intervensi::class, $kampung]);

        $this->programRepository->pushCriteria(ProgramIntervensiCriteria::class);
        $programs = $this->programRepository->get()->pluck('name', 'id');

        $inpresKegiatans = $this->inpresKegiatanRepository->get()->pluck('name', 'id');
        $inpresKegiatans->put(-1, 'Lainnya');

        $jenisPosts = $this->jenisPostRepository->with('intervensi_gambar_types')->get();
        $kategories = $this->kategoriRepository->get()->pluck('name', 'id');
        $sasarans = $this->sasaranRepository->pluck('name', 'id');
        $instansis = $this->instansiRepository->pluck('name', 'id');

        if (request()->has('debug')) dd(
            ['inpresKegiatans' => $inpresKegiatans->toArray()],
            ['jenisPosts' => $jenisPosts->toArray()]
        );


        return view('admin.kampung.intervensi.create', compact(
            'kampung',
            'kategories',
            'programs',
            'sasarans',
            'instansis',
            'inpresKegiatans',
            'jenisPosts'
        ));
    }

    public function store(CreateRequest $request, $kampungId)
    {

        $this->kampungRepository->skipCache();
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('create', [Intervensi::class, $kampung]);

        # Merge with kampung id into request
        $input = $request
            ->merge(['kampung_kb_id' => $kampungId])
            ->all();

        # Remove fileuploaded from gambar
        $input['intervensi_gambars'] = array_map(function ($gambar) {
            unset($gambar['file']);
            return $gambar;
        }, $input['intervensi_gambars'] ?? []);

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Insert Berhasil.',
            'message' => 'Intervensi kampung KB berhasil dipublish.'
        ];

        DB::beginTransaction();

        try {

            # Insert new intervensi
            $intervensi = $this->intervensiRepository->create($input);

            # Insert sasaran pivot
            $intervensi->sasarans()->attach($input['sasarans']);
            foreach ($input['sasaran_lainnya'] as $sasaran) {
                $intervensi->sasarans()->attach([9 => ['sasaran_lainnya' => $sasaran]]);
            }

            # Insert instansi pivot
            $intervensi->instansis()->attach($input['instansis']);
            foreach ($input['instansi_lainnya'] as $instansi) {
                $intervensi->instansis()->attach([37 => ['instansi_lainnya' => $instansi]]);
            }

            # Uploading file based on wilayah
            if (!empty($input['intervensi_gambars'])) {
                $directory = $this->kampungService->generateKampungPath($kampung, 'public') . $this->kampungService->generateIntervensiPath($intervensi);

                foreach ($input['intervensi_gambars'] ?? [] as $key => $intervensi_gambar) {
                    $base64 = $intervensi_gambar['base64'];
                    $ext = explode('/', mime_content_type($base64))[1];
                    $path = $directory . time() . $key . '.' . $ext;
                    $img = Image::make(file_get_contents($base64))
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream($ext, 90)
                        ;;

                    Storage::put($path, $img);
                    $input['intervensi_gambars'][$key]['path'] = $path;
                }

                # Insert gambar detail
                $intervensi->intervensi_gambars()->createMany($input['intervensi_gambars']);
            }

            DB::commit();

            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', $alert);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return back()
                    ->withInput()
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Update Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]);
            }

            report($e);
        }

        return redirect()->route('admin.kampungs.show', ['kampung' => $kampungId]);
    }


    public function edit(Request $request, $kampungId, $intervensiId)
    {

        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        $this->intervensiRepository->pushCriteria(IntervensiAdminShowCriteria::class);
        $intervensi = $this->intervensiRepository->find($intervensiId);

        # Policy
        $this->authorize('update', [$intervensi, $kampung]);

        $intervensiSasaranMap = $intervensi->sasarans->pluck('pivot.sasaran_lainnya', 'id');
        $intervensiInstansiMap = $intervensi->instansis->pluck('pivot.instansi_lainnya', 'id');
        $intervensiGambarMap = $intervensi->intervensi_gambars->mapWithKeys(function ($gambar) {
            $output = [];
            $key = $gambar->intervensi_gambar_type_id;
            $output[$key] = [
                'id' => $gambar->id,
                'caption' => $gambar->caption,
                'intervensi_gambar_type_id' => $gambar->intervensi_gambar_type_id,
            ];

            if (Storage::exists($gambar->path)) {
                $output[$key]['base64'] = 'data:image/' . \File::extension($gambar->path) . ';base64,' . base64_encode(Storage::get($gambar->path));
            }

            if (!empty($gambar->url)) {
                $output[$key]['url'] = $gambar->url;
            }

            return $output;
        });

        $this->programRepository->pushCriteria(ProgramIntervensiCriteria::class);
        $programs = $this->programRepository->get()->pluck('name', 'id');

        $jenisPosts = $this->jenisPostRepository->with('intervensi_gambar_types')->get();
        $kategories = $this->kategoriRepository->get()->pluck('name', 'id');
        $sasarans = $this->sasaranRepository->pluck('name', 'id');
        $instansis = $this->instansiRepository->pluck('name', 'id');

        if (request()->has('debug')) dd(
            ['intervensi' => $intervensi->toArray()],
            ['jenisPosts' => $jenisPosts->toArray()],
            ['intervensiSasaranMap' => $intervensiSasaranMap->toArray()],
            ['intervensiInstansiMap' => $intervensiInstansiMap->toArray()],
            ['intervensiGambarMap' => $intervensiGambarMap->toArray()],
            ['img' => Storage::url($intervensi->intervensi_gambars->first()->path)]
        );


        return view('admin.kampung.intervensi.edit', compact(
            'intervensi',
            'intervensiGambarMap',
            'intervensiSasaranMap',
            'intervensiInstansiMap',
            'kampung',
            'kategories',
            'programs',
            'sasarans',
            'instansis',
            'jenisPosts'
        ));
    }


    public function update(UpdateRequest $request, $kampungId, $intervensiId)
    {

        $this->kampungRepository->skipCache();
        $this->kampungRepository->pushCriteria(KampungCriteria::class);
        $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        # Policy
        $this->authorize('update', [Intervensi::find($intervensiId), $kampung]);

        $input = $request->all();

        $input['intervensi_gambars'] = array_map(function ($gambar) {
            unset($gambar['file']);
            return $gambar;
        }, $input['intervensi_gambars'] ?? []);

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Update Berhasil.',
            'message' => 'Intervensi kampung KB berhasil diperbaharui.'
        ];

        DB::beginTransaction();

        try {

            # Insert new intervensi
            $intervensi = $this->intervensiRepository->update($input, $intervensiId);

            # Insert sasaran pivot
            $intervensi->sasarans()->sync($input['sasarans']);
            foreach ($input['sasaran_lainnya'] as $sasaran) {
                $intervensi->sasarans()->attach([9 => ['sasaran_lainnya' => $sasaran]]);
            }

            # Insert instansi pivot
            $intervensi->instansis()->sync($input['instansis']);
            foreach ($input['instansi_lainnya'] as $instansi) {
                $intervensi->instansis()->attach([37 => ['instansi_lainnya' => $instansi]]);
            }

            # Get wilayah  from kampung for directory path
            $this->kampungRepository->pushCriteria(KampungWilayahCriteria::class);
            $kampung = $this->kampungRepository->find($kampungId);

            $directory = $this->kampungService->generateKampungPath($kampung, 'public') . $this->kampungService->generateIntervensiPath($intervensi);

            # Remove current image file and related
            $gambars = $intervensi->load('intervensi_gambars')->intervensi_gambars;
            Storage::delete($gambars->pluck('path'));
            $intervensi->intervensi_gambars()->delete();


            foreach ($input['intervensi_gambars'] ?? [] as $key => $intervensi_gambar) {
                $base64 = $intervensi_gambar['base64'];
                $ext = explode('/', mime_content_type($base64))[1];
                $path = $directory . time() . $key . '.' . $ext;
                $img = Image::make(file_get_contents($base64))
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->stream($ext, 90)
                    ;

                Storage::put($path, $img);
                $input['intervensi_gambars'][$key]['path'] = $path;
            }

            # Insert gambar detail
            $intervensi->intervensi_gambars()->createMany($input['intervensi_gambars']);

            DB::commit();

            if ($request->wantsJson()) {
                return true;
            }

            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', $alert);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return back()
                    ->withInput()
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Update Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]);
            }

            report($e);
        }

        return redirect()->route('admin.kampungs.show', ['kampung' => $kampungId]);

    }


    public function destroy(Request $request, $kampungId, $intervensiId)
    {

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Hapus Berhasil.',
            'message' => 'Intervensi kampung KB berhasil dihapus.'
        ];


        DB::beginTransaction();

        try {

            # Insert new intervensi
            $intervensi = $this->intervensiRepository->delete($intervensiId);

            DB::commit();

            return redirect()
                ->route('admin.kampungs.show', ['kampung' => $kampungId])
                ->with('alert', $alert);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return back()
                    ->withInput()
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Update Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]);
            }

            report($e);
        }
    }
}
