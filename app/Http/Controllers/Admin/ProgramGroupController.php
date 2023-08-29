<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\ProgramGroup;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\ProgramGroupDataTable;
use App\Repositories\Contract\{
    ProgramGroupRepository,
    ProgramRepository,
};
use Illuminate\Http\Request;


class ProgramGroupController extends Controller
{
    protected $repository, $programRepository;
    protected $dataTable;


    public function __construct(ProgramGroupRepository $repository,ProgramRepository $programRepository, ProgramGroupDataTable $dataTable)
    {

        $this->repository = $repository;
        $this->programRepository = $programRepository;
        $this->dataTable = $dataTable;
    }


    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', ProgramGroup::class);

        return $this->dataTable->render('admin.program-group.index');
    }

    public function create()
    {

        # Policy
        $this->authorize('create', ProgramGroup::class);

        $programs = $this->programRepository->get()->pluck('name', 'id');

        return view('admin.program-group.create', compact('programs'));
    }


    public function store(Request $request)
    {

        # Policy
        $this->authorize('create', ProgramGroup::class);

        $input = $request->all();

        DB::beginTransaction();

        try {

            # update group
            $group = $this->repository->create($input);

            # Insert pivot program
            if(isset($input['programs'])){
                $group->programs()->sync($input['programs']);
            }

            DB::commit();

            return redirect()
                ->route('admin.program-group.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Master Group Program berhasil ditambah.'
                ]);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return back()
                    ->withInput()
                    ->with(['alert'], [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]);
            }

            report($e);
        }
    }

    public function edit(Request $request, $id)
    {

        $group = $this->repository->with('programs')->find($id);

        # Policy
        $this->authorize('update', $group);

        $programs = $this->programRepository->get()->pluck('name', 'id');
        $groupProgramMap = $group->programs->pluck('name', 'id');
        return view('admin.program-group.edit', compact('programs', 'group', 'groupProgramMap'));
    }

    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', ProgramGroup::find($id));

        $input = $request->all();

        DB::beginTransaction();

        try {

            # update group
            $group = $this->repository->update($input, $id);

            # Insert pivot program
            if(isset($input['programs'])){
                $group->programs()->sync($input['programs']);
            }else{
                $group->programs()->detach();
            }

            DB::commit();

            return redirect()
                ->route('admin.program-group.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master Group Program berhasil diperbaharui.'
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
        $this->authorize('delete', ProgramGroup::find($id));

        DB::beginTransaction();

        try {

            # delete program
            $keyword = $this->repository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.program-group.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Berhasil.',
                    'message' => 'Group Program berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.program-group.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Group Program tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.program-group.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Group Program tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            report($e);
        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.program-group.index')
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
