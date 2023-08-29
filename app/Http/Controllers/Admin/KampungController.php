<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Log;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

use App\Repositories\Criteria\Kampung\Admin\ShowCriteria as KampungAdminShowCriteria;
use App\Models\Kampung;
use App\Repositories\Contract\{
    DesaRepository,
    KabupatenRepository,
    KampungRepository,
    KecamatanRepository,
    KriteriaRepository,
    ProvinsiRepository
};
use App\DataTables\Admin\{
    KampungDataTable,
    Kampung\ProfilDataTable,
    Kampung\PendudukDataTable,
    Kampung\IntervensiDataTable,
    Kampung\KkbpkDataTable
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Kampung\{
    CreateRequest,
    UpdateRequest
};
use App\Services\KampungService;


class KampungController extends Controller
{

    protected $dataTable;
    protected $profilDataTable;
    protected $repository,
        $desaRepository,
        $kabupatenRepository,
        $kecamatanRepository,
        $kriteriaRepository,
        $provinsiRepository
        ;

    protected $kampungService;

    public function __construct(
        KampungDataTable $dataTable,

        DesaRepository $desaRepository,
        KabupatenRepository $kabupatenRepository,
        KampungRepository $repository,
        KecamatanRepository $kecamatanRepository,
        KriteriaRepository $kriteriaRepository,
        ProvinsiRepository $provinsiRepository,

        KampungService $kampungService
    ) {

        $this->dataTable = $dataTable;

        $this->repository = $repository;
        $this->desaRepository = $desaRepository;
        $this->kabupatenRepository = $kabupatenRepository;
        $this->kecamatanRepository = $kecamatanRepository;
        $this->kriteriaRepository = $kriteriaRepository;
        $this->provinsiRepository = $provinsiRepository;

        $this->kampungService = $kampungService;
    }

    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', Kampung::class);

        return $this->dataTable->render('admin.kampung.index');
    }


    public function create(Request $request)
    {

        # Policy
        $this->authorize('create', Kampung::class);

        $provinsis = $this->provinsiRepository->get()->pluck('name', 'id');
        $kriterias = $this->kriteriaRepository->get();

        return view('admin.kampung.informasi.create', compact(
            'provinsis',
            'kriterias'
        ));
    }


    public function store(CreateRequest $request)
    {

        # Policy
        $this->authorize('create', Kampung::class);

        $input = $request
            ->merge(['penanggungjawab_id' => 5]) # should be replace soon
            ->all();

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Insert Berhasil.',
            'message' => 'Master kampung KB berhasil ditambah.'
        ];


        DB::beginTransaction();

        try {


            # Insert new kampung
            $kampung = $this->repository->create($input);

            # If any upload
            if (!empty($input['gambar']['base64']) || !empty($input['pengurus']['base64'])) {

                $directory = $this->kampungService->generateKampungPath($kampung, 'public');

                # Upload Gambar
                if (!empty($input['gambar']['base64'])) {
                    $base64 = $input['gambar']['base64'];
                    $ext = explode('/', mime_content_type($base64))[1];
                    $path = $directory . 'gambar.' . $ext;
                    $img = Image::make(file_get_contents($base64))
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream($ext, 90)
                        ;

                    Storage::put($path, $img);
                    $kampung->path_gambar = $path;
                    $kampung->save();
                }

                # Upload kepengurusan
                if (!empty($input['pengurus']['base64'])) {
                    $base64 = $input['pengurus']['base64'];
                    $ext = explode('/', mime_content_type($base64))[1];
                    $path = $directory . 'struktur.' . $ext;
                    $img = Image::make(file_get_contents($base64))
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream($ext, 90)
                        ;

                    Storage::put($path, $img);
                    $kampung->path_struktur = $path;
                    $kampung->save();
                }
            }

            # Insert kampung kriteria
            if (!empty($input['kriterias'])) {
                $kampung = $kampung->kriterias()->attach($input['kriterias']);
            }

            DB::commit();

            return redirect()
                ->route('admin.kampungs.index')
                ->with('alert', $alert);

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


    public function show(
        ProfilDataTable $profilDataTable,
        PendudukDataTable $pendudukDataTable,
        IntervensiDataTable $intervensiDataTable,
        KkbpkDataTable $kkbpkDataTable,
        $id
    ) {


        $this->repository->pushCriteria(KampungAdminShowCriteria::class);
        $kampung = $this->repository->find($id);

        # Policy
        $this->authorize('view', $kampung);

        return view('admin.kampung.show', compact(
            'kampung',
            'profilDataTable',
            'pendudukDataTable',
            'intervensiDataTable',
            'kkbpkDataTable'
        ));
    }

    public function edit(Request $request, $id)
    {

        $this->repository->pushCriteria(KampungAdminShowCriteria::class);
        $kampung = $this->repository->find($id);

        # Policy
        $this->authorize('update', $kampung);

        $kampungKriteriaMap = $kampung->kriterias->pluck(true, 'id');

        $kriterias = $this->kriteriaRepository->get();

        if (request()->has('debug')) dd(
            ['kampung' => $kampung->toArray()],
            ['kampungKriteriaMap' => $kampungKriteriaMap->toArray()]
        );

        return view('admin.kampung.informasi.edit', compact(
            'kampung',
            'kriterias',
            'kampungKriteriaMap'
        ));
    }

    public function update(UpdateRequest $request, Kampung $kampung)
    {

        $this->authorize('update', $kampung);

        $input = $request->all();

        $alert = [
            'variant' => 'success',
            'title' => 'Update Berhasil.',
            'message' => 'Master kampung KB berhasil diperbaharui.'
        ];

        DB::beginTransaction();

        try {

            if (!empty($input['gambar']['base64']) || !empty($input['pengurus']['base64'])) {

                $directory = $this->kampungService->generateKampungPath($kampung, 'public');

                # Upload Gambar
                if (!empty($input['gambar']['base64'])) {
                    $base64 = $input['gambar']['base64'];
                    $ext = explode('/', mime_content_type($base64))[1];
                    $path = $directory . 'gambar.' . $ext;
                    $img = Image::make(file_get_contents($base64))
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream($ext, 90)
                        ;

                    Storage::put($path, $img);
                    $input['path_gambar'] = $path;
                }

                # Upload kepengurusan
                if (!empty($input['pengurus']['base64'])) {
                    $base64 = $input['pengurus']['base64'];
                    $ext = explode('/', mime_content_type($base64))[1];
                    $path = $directory . 'struktur.' . $ext;
                    $img = Image::make(file_get_contents($base64))
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream($ext, 90)
                        ;

                    Storage::put($path, $img);
                    $input['path_struktur'] = $path;
                }
            }

            # Update Existing
            $kampung = $this->repository->update($input, $kampung->id);

            # Insert kampung kriteria
            if (!empty($input['kriterias'])) {
                $kampung->kriterias()->sync($input['kriterias']);
            }

            DB::commit();

            return redirect()
                ->route('admin.kampungs.show', compact('kampung'))
                ->with('alert', $alert);

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

    public function destroy($id)
    {
        # Policy
        #$this->authorize('delete', Kampung::find($id));

        DB::beginTransaction();

        try {

            # update status null
            $kampung = $this->repository->update(['is_active' => null], $id);

            DB::commit();

            return redirect()
                ->route('admin.kampungs.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Hapus Berhasil.',
                    'message' => 'Kampung KB berhasil dihapus.'
                ]);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.kampungs.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Hapus Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]
                );
            }

            report($e);
        }
    }
}
