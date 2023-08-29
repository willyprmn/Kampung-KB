<?php

namespace App\Http\Controllers\Admin;

use DB;
use Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\DataTables\Admin\RoleDataTable;
use App\Repositories\Contract\RoleRepository;
use App\Repositories\Contract\MenuRepository;
use App\Exceptions\NoActionException;

class RoleController extends Controller
{

    protected $dataTable;
    protected $repository;
    protected $menuRepository;

    public function __construct(
        RoleDataTable $dataTable,
        RoleRepository $repository,
        MenuRepository $menuRepository
    ) {

        $this->dataTable = $dataTable;
        $this->repository = $repository;
        $this->menuRepository = $menuRepository;
    }


    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', Role::class);

        return $this->dataTable->render('admin.role.index');
    }

    public function create()
    {

        # Policy
        $this->authorize('create', Role::class);

        $roles = $this->repository->get()->pluck('name', 'id');
        $permissions = [];
        $menus = $this->menuRepository
            ->where('parent_id', null)
            ->with('children.children')
            ->get();

        # Debug
        if (request()->has('debug')) dd([
            'menus' => $menus->toArray(),
        ]);

        return view('admin.role.create', compact('permissions', 'menus', 'roles'));
    }


    public function store(Request $request)
    {

        $this->authorize('create', Role::class);

        $input = $request->all();

         # Default alert
         $alert = [
            'variant' => 'success',
            'title' => 'Insert Berhasil.',
            'message' => 'Pengaturan hak aksess berhasil ditambah.'
        ];

        DB::beginTransaction();

        try {

            # Save Role
            $role = $this->repository->create($input);

            # Sync Pivot
            $role->menus()->sync($input['menus']);

            # Sync Role Children
            if (!empty($input['roles'])) {
                $role->children()->sync($input['roles']);
            }

            DB::commit();

            if ($request->wantsJson()) {
                return true;
            }

            return redirect()
                ->route('admin.role.index')
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



    public function edit(Request $request, $id)
    {

        $role = $this->repository
            ->with([
                'children',
                'menus' => function ($menu) {
                    return $menu->where('is_menu', false);
                },
            ])
            ->find($id);

        # Policy
        $this->authorize('update', $role);

        $roles = $this->repository
            ->where('id', '<>', $id)
            ->get()
            ->pluck('name', 'id');

        $permissions = $role->menus->pluck("id");

        $menus = $this->menuRepository
            ->where('parent_id', null)
            ->with('children.children')
            ->get();

        # Debug
        if (request()->has('debug')) dd([
            'role' => $role->toArray(),
            'menus' => $menus->toArray(),
        ]);

        return view('admin.role.edit', compact('role', 'permissions', 'roles', 'menus'));
    }


    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', Role::find($id));

        $input = $request->all();

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Update Berhasil.',
            'message' => 'Pengaturan hak aksess berhasil diperbaharui.'
        ];

        DB::beginTransaction();

        try {

            # Save Role
            $role = $this->repository->update($input, $id);

            # Sync Pivot
            $role->menus()->sync($input['menus']);

            # Sync Role Children
            if (!empty($input['roles'])) {
                $role->children()->sync($input['roles']);
            }

            DB::commit();

            if ($request->wantsJson()) {
                return true;
            }

            return redirect()
                ->route('admin.role.index')
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


    public function destroy($id)
    {

        # Policy
        $this->authorize('delete', Role::find($id));

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Delete Berhasil.',
            'message' => 'Pengaturan hak aksess berhasil dihapus.'
        ];

        DB::beginTransaction();

        try {

            # Save Role
            $this->repository->skipCache();
            $role = $this->repository->withCount('users')->find($id);

            if ($role->users_count > 0) {
                throw new NoActionException("Terdapat {$role->users_count} user menggunakan hak akses yang hendak dihapus.");
            }

            # Remove Pivot
            $role->menus()->detach();
            $role->children()->detach();

            # Remove model;
            $role->delete();

            DB::commit();

            return redirect()
                ->route('admin.role.index')
                ->with('alert', $alert);

        } catch (NoActionException $e) {

            DB::rollback();
            return redirect()
                ->route('admin.role.index')
                ->with('alert', [
                    'variant' => 'danger',
                    'title' => 'Hak akses tidak dapat dihapus.',
                    'message' => $e->getMessage()
                ]);

        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return back()
                    ->withInput()
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Delete Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]);
            }

            report($e);
        }
    }
}
