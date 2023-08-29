<?php

namespace App\Http\Controllers\Admin\Inpres;

use DB;
use Log;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\Inpres\KegiatanDataTable;
use App\Models\InpresKegiatan;
use App\Repositories\Contract\{
    InstansiRepository,
    InpresProgramRepository,
    InpresKegiatanRepository,
    KeywordRepository,
    KementerianRepository
};
use Illuminate\Http\Request;

class KegiatanController extends Controller
{

    protected $dataTable;
    protected $instansiRepository;
    protected $programRepository;
    protected $kegiatanRepository;
    protected $keywordRepository;
    protected $kementerianRepository;

    public function __construct(
        KegiatanDataTable $dataTable,
        InstansiRepository $instansiRepository,
        InpresProgramRepository $programRepository,
        InpresKegiatanRepository $kegiatanRepository,
        KeywordRepository $keywordRepository,
        KementerianRepository $kementerianRepository
    ) {

        $this->dataTable = $dataTable;
        $this->instansiRepository = $instansiRepository;
        $this->programRepository = $programRepository;
        $this->kegiatanRepository = $kegiatanRepository;
        $this->keywordRepository = $keywordRepository;
        $this->kementerianRepository = $kementerianRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        # Policy
        $this->authorize('viewAny', InpresKegiatan::class);

        return $this->dataTable->render('admin.inpres.kegiatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        # Policy
        $this->authorize('create', InpresKegiatan::class);

        $keywords = $this->keywordRepository->get()->pluck('name', 'id');
        $instansis = $this->instansiRepository->get()->pluck('name', 'id');
        $programs = $this->programRepository->get()->pluck('name', 'id');
        $kementerians = $this->kementerianRepository->get()->pluck('name', 'id');
        
        return view('admin.inpres.kegiatan.create', compact('programs', 'keywords', 'instansis', 'kementerians'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        # Policy
        $this->authorize('create', InpresKegiatan::class);

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new kegiatan
            $kegiatan = $this->kegiatanRepository->create($input);

            # Attach keyword
            if (!empty($input['keywords']))
            $kegiatan->keywords()->attach($input['keywords']);

            # Attach instansis
            if (!empty($input['instansis']))
            $kegiatan->instansis()->attach($input['instansis']);

            DB::commit();

            return redirect()
                ->route('admin.inpres-kegiatan.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Master Kegiatan Inpres berhasil ditambah.'
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(InpresKegiatan $inpresKegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        # Policy
        $this->authorize('update', InpresKegiatan::find($id));

        $keywords = $this->keywordRepository->get()->pluck('name', 'id');
        $instansis = $this->instansiRepository->get()->pluck('name', 'id');
        $programs = $this->programRepository->get()->pluck('name', 'id');
        $kegiatan = $this->kegiatanRepository->with(['instansis', 'keywords'])->find($id);
        $kementerians = $this->kementerianRepository->get()->pluck('name', 'id');

        return view('admin.inpres.kegiatan.edit', compact('programs', 'kegiatan', 'keywords', 'instansis', 'kementerians'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('viewAny', $this->kegiatanRepository->find($id));

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $kegiatan = $this->kegiatanRepository->update($input, $id);

            # Attach keyword
            if (!empty($input['keywords'])){
                $kegiatan->keywords()->sync($input['keywords']);
            }else{
                $kegiatan->keywords()->detach();
            }

            # Attach instansis
            if (!empty($input['instansis'])){
                $kegiatan->instansis()->sync($input['instansis']);
            }else{
                $kegiatan->instansis()->detach();
            }

            DB::commit();

            return redirect()
                ->route('admin.inpres-kegiatan.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master Kegiatan Inpres berhasil diperbaharui.'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        # Policy
        $this->authorize('delete', $this->kegiatanRepository->find($id));

        DB::beginTransaction();

        try {

            # delete kegiatan
            $sasaran = $this->kegiatanRepository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.inpres-kegiatan.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Hapus Berhasil.',
                    'message' => 'Kegiatan Inpres berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
            }

            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.inpres-kegiatan.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Hapus Gagal.',
                        'message' => 'Kegiatan Inpres tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            return redirect()
                ->route('admin.inpres-kegiatan.index')
                ->with('alert', [
                    'variant' => 'danger',
                    'title' => 'Hapus Gagal.',
                    'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                ]
            );
            report($e);
        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.inpres-program.index')
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
