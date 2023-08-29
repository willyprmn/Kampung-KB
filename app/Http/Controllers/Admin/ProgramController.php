<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Program;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\ProgramDataTable;
use App\Http\Requests\Program\CreateRequest;
use App\Repositories\Contract\{
    ProgramRepository,
};
use Illuminate\Http\Request;


class ProgramController extends Controller
{
    protected $repository;
    protected $dataTable;


    public function __construct(ProgramRepository $repository, ProgramDataTable $dataTable)
    {

        $this->repository = $repository;
        $this->dataTable = $dataTable;
    }


    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', Program::class);

        return $this->dataTable->render('admin.program.index');
    }

    public function create()
    {

        # Policy
        $this->authorize('create', Program::class);

        return view('admin.program.create');
    }


    public function store(Request $request)
    {

        # Policy
        $this->authorize('create', Program::class);

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $keyword = $this->repository->create($input);

            DB::commit();

            return redirect()
                ->route('admin.program.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Program berhasil ditambah.'
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

        $program = $this->repository->find($id);

        # Policy
        $this->authorize('update', $program);

        return view('admin.program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', Program::find($id));

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $program = $this->repository->update($input, $id);

            DB::commit();

            return redirect()
                ->route('admin.program.index')
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
        $this->authorize('delete', Program::find($id));

        DB::beginTransaction();

        try {

            # delete program
            $keyword = $this->repository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.program.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Berhasil.',
                    'message' => 'Program berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.program.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Program tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.program.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Program tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            report($e);
        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.program.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]
                );
            }

            report($e);
        }
    }
}
