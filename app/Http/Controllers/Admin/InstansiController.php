<?php

namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Str;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\InstansiDataTable;
use App\Models\Instansi;
use App\Repositories\Contract\{
    InstansiRepository,
    KeywordRepository,
};
use Illuminate\Http\Request;

class InstansiController extends Controller
{

    protected $dataTable;
    protected $repository,
        $keywordRepository
        ;


    public function __construct(
        InstansiDataTable $dataTable,
        InstansiRepository $repository,
        KeywordRepository $keywordRepository
    ) {

        $this->dataTable = $dataTable;
        $this->repository = $repository;

        $this->keywordRepository = $keywordRepository;
    }


    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', Instansi::class);

        return $this->dataTable->render('admin.instansi.index');
    }


    public function create()
    {

        # Policy
        $this->authorize('create', Instansi::class);

        $keywords = $this->keywordRepository->get()->pluck('name', 'id');
        return view('admin.instansi.create', compact('keywords'));
    }


    public function store(Request $request)
    {

        # Policy
        $this->authorize('create', Instansi::class);

        $input = $request->all();
        $input['alias'] = Str::snake($input['name']);

        DB::beginTransaction();

        try {

            # Insert new keyword
            $instansi = $this->repository->create($input);

            # Insert pivot keywords
            if (!empty($input['keywords']))
            $instansi->keywords()->sync($input['keywords']);

            DB::commit();

            return redirect()
                ->route('admin.instansi.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Master instansi berhasil ditambah.'
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


    public function edit(Request $request, $id)
    {

        $instansi = $this->repository->with('keywords')->find($id);

        # Policy
        $this->authorize('update', $instansi);

        $keywords = $this->keywordRepository->get()->pluck('name', 'id');
        $instansiKeywordMap = $instansi->keywords->pluck('name', 'id');
        return view('admin.instansi.edit', compact(
            'instansi',
            'keywords',
            'instansiKeywordMap'
        ));
    }

    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', Instansi::find($id));

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $instansi = $this->repository->update($input, $id);

            # Insert pivot keywords
            if (isset($input['keywords'])) {
                $instansi->keywords()->sync($input['keywords']);
            }

            DB::commit();

            return redirect()
                ->route('admin.instansi.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master instansi berhasil diperbaharui.'
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

    public function destroy($id)
    {
        # Policy
        $this->authorize('delete', Instansi::find($id));

        DB::beginTransaction();

        try {

            # delete sasaran
            $sasaran = $this->repository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.instansi.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Hapus Berhasil.',
                    'message' => 'Instansi berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
            }

            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.instansi.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Hapus Gagal.',
                        'message' => 'Instansi tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            return redirect()
                ->route('admin.instansi.index')
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
                    ->route('admin.instansi.index')
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
