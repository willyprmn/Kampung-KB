<?php

namespace App\Http\Controllers\Admin;

use DB;
use Log;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use App\Repositories\Contract\KeywordRepository;
use App\DataTables\Admin\KeywordDataTable;
use App\Http\Requests\Admin\Keyword\CreateRequest;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    protected $repository;
    protected $dataTable;


    public function __construct(KeywordRepository $repository, KeywordDataTable $dataTable)
    {

        $this->repository = $repository;
        $this->dataTable = $dataTable;
    }


    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', Keyword::class);

        return $this->dataTable->render('admin.keyword.index');
    }

    public function create()
    {

        # Policy
        $this->authorize('create', Keyword::class);

        return view('admin.keyword.create');
    }


    public function store(CreateRequest $request)
    {

        # Policy
        $this->authorize('create', Keyword::class);

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $keyword = $this->repository->create($input);

            DB::commit();

            return redirect()
                ->route('admin.keyword.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'keyword berhasil ditambah.'
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
        $keyword = $this->repository->find($id);

        # Policy
        $this->authorize('update', $keyword);

        return view('admin.keyword.edit', compact('keyword'));
    }

    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', Keyword::find($id));

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $program = $this->repository->update($input, $id);

            DB::commit();

            return redirect()
                ->route('admin.keyword.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master Program berhasil diperbaharui.'
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
        $this->authorize('delete', Keyword::find($id));

        DB::beginTransaction();

        try {

            # delete keyword
            $keyword = $this->repository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.keyword.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Hapus Berhasil.',
                    'message' => 'Keyword berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
            }
            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.keyword.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Hapus Gagal.',
                        'message' => 'Keyword tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }

            return redirect()
                ->route('admin.keyword.index')
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
                    ->route('admin.keyword.index')
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
