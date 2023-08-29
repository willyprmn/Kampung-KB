<?php

namespace App\Http\Controllers\Admin;

use Hash;
use DB;
use Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Admin\User\{
    CreateRequest,
    UpdateRequest,
    UpdatePasswordRequest,
};
use App\Repositories\Contract\{
    ProvinsiRepository,
    RoleRepository,
    UserRepository
};
use App\DataTables\Admin\UserDataTable;
use Auth;

class UserController extends Controller
{

    protected $repository;
    protected $provinsiRepository;
    protected $roleRepository;
    protected $dataTable;


    public function __construct(
        UserDataTable $dataTable,
        ProvinsiRepository $provinsiRepository,
        RoleRepository $roleRepository,
        UserRepository $repository
    ) {

        $this->dataTable = $dataTable;
        $this->provinsiRepository = $provinsiRepository;
        $this->roleRepository = $roleRepository;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        # Policy
        $this->authorize('viewAny', User::class);

        return $this->dataTable->render('admin.user.index');
    }


    public function create(Request $request)
    {

        # Policy
        $this->authorize('create', User::class);

        # Get provinsi
        $provinsis = $this->provinsiRepository->get()->pluck('name', 'id');

        $roleChildren = Auth::user()
            ->roles()
            ->with('children')
            ->get()
            ->pluck('children.*.id')
            ->collapse()
            ->toArray()
            ;

        # Get available role for user
        $roles = $this->roleRepository
            ->whereIn('id', $roleChildren)
            ->get()
            ->pluck('name', 'id');

        return view('admin.user.create', compact('provinsis', 'roles'));
    }

    public function store(CreateRequest $request)
    {

        # Policy
        $this->authorize('create', User::class);

        $input = array_merge(
            $request->validated(),
            [
                'password' => Hash::make($request['password']),
                'siga_id' => Hash::make(time()),
            ]
        );


        DB::beginTransaction();

        try {

            # Insert new user
            $user = $this->repository->create($input);

            # Insert pivot keywords
            $user->roles()->sync($input['roles']);

            DB::commit();

            return redirect()
                ->route('admin.user.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Master user berhasil ditambah.'
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

        $user = $this->repository->with('roles')->find($id);

        # Policy
        $this->authorize('update', $user);

        $provinsis = $this->provinsiRepository->get()->pluck('name', 'id');

        $roleChildren = Auth::user()
            ->roles()
            ->with('children')
            ->get()
            ->pluck('children.*.id')
            ->collapse()
            ->toArray()
            ;

        # Get available role for user
        $roles = $this->roleRepository
            ->whereIn('id', $roleChildren)
            ->get()
            ->pluck('name', 'id');

        return view('admin.user.edit', compact('user', 'provinsis', 'roles'));

    }


    public function update(UpdateRequest $request, $id)
    {

        # Policy
        $this->authorize('update', User::find($id));

        $input = $request->validated();

        DB::beginTransaction();

        try {

            # update new user
            $user = $this->repository->update($input, $id);

            # Insert pivot keywords
            $user->roles()->sync($input['roles']);

            DB::commit();

            return redirect()
                ->route('admin.user.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master user berhasil diperbaharui.'
                ]);

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

    public function reset($id)
    {

        # Policy
        $this->authorize('reset', User::find($id));

        DB::beginTransaction();

        try {

            # Insert new user
            $defaultValue = 'P@ssw0rd';
            $input = [
                'password' => Hash::make($defaultValue)
            ];

            $user = $this->repository->update($input, $id);

            DB::commit();

            return redirect()
                ->route('admin.user.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Reset Berhasil.',
                    'message' => 'User' . $user->email . 'berhasil di reset dengan password :' . $defaultValue
                ]);

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
        $this->authorize('delete', User::find($id));

        DB::beginTransaction();

        try {

            # Insert new keyword
            $keyword = $this->repository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.user.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Berhasil.',
                    'message' => 'User berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.user.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'User tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.user.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'User tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            report($e);
        } catch (Throwable $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.user.index')
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

    public function profile(){
        try{
            $user = $this->repository->with(['roles', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])->find(Auth::user()->id);
            return view('admin.user.profile.index', compact('user'));

        }catch(\Throwable $e){
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.user.profile')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]
                );
            }
            if (request()->has('debug')) dd($e->getMessage());
            dd($e);
        }
    }

    public function profilEdit()
    {

        try {

            $user = $this->repository->with(['roles', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])
                ->find(Auth::user()->id);

            return view('admin.user.profile.edit', compact('user'));

        } catch(\Throwable $e) {

            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.user.profile')
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

    public function profileUpdate(UpdatePasswordRequest $request){
        try{

            $user = $this->repository->find(Auth::user()->id);

            if (Hash::check($request->password_old, $user->password)) {
                $user->fill([
                    'password' => Hash::make($request->password)
                ])->save();

                return redirect()
                    ->route('admin.profile')
                    ->with('alert', [
                        'variant' => 'success',
                        'title' => 'Berhasil.',
                        'message' => 'Ubah password berhasil.'
                    ]);

            } else {
                return back()
                    ->withInput()
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Password lama tidak sesuai!'
                    ]
                );
            }

            $user = $this->repository->with(['roles', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])->find(Auth::user()->id);
            return view('admin.user.profile', compact('user'));

        }catch(\Throwable $e){
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
                return redirect()
                    ->route('admin.user.profile')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Gagal.',
                        'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                    ]
                );
            }
            if (request()->has('debug')) dd($e->getMessage());
            dd($e);
        }
    }

}
