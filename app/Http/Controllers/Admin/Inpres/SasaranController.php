<?php

namespace App\Http\Controllers\Admin\Inpres;

use DB;
use Log;

use App\Http\Controllers\Controller;
use App\Models\InpresSasaran;
use App\Repositories\Contract\InpresSasaranRepository;
use Illuminate\Http\Request;
use App\DataTables\Admin\Inpres\SasaranDataTable;

class SasaranController extends Controller
{

    protected $dataTable;
    protected $repository;

    public function __construct(
        SasaranDataTable $dataTable,
        InpresSasaranRepository $repository
    ) {

        $this->dataTable = $dataTable;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        # Policy
        $this->authorize('viewAny', InpresSasaran::class);

        return $this->dataTable->render('admin.inpres.sasaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        # Policy
        $this->authorize('create', InpresSasaran::class);

        return view('admin.inpres.sasaran.create');
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
        $this->authorize('create', InpresSasaran::class);

        $input = $request
            ->merge(['inpres_id' => 1])
            ->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $sasaran = $this->repository->create($input);

            DB::commit();

            return redirect()
                ->route('admin.inpres-sasaran.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Master Sasaran Inpres berhasil ditambah.'
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
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return \Illuminate\Http\Response
     */
    public function show(InpresSasaran $inpresSasaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        # Policy
        $this->authorize('update', InpresSasaran::find($id));

        $sasaran = $this->repository->find($id);
        return view('admin.inpres.sasaran.edit', compact('sasaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', $this->repository->find($id));

        $input = $request
            ->merge(['inpres_id' => 1])
            ->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $sasaran = $this->repository->update($input, $id);

            DB::commit();

            return redirect()
                ->route('admin.inpres-sasaran.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master Sasaran Inpres berhasil dirubah.'
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
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        # Policy
        $this->authorize('delete', InpresSasaran::find($id));

        DB::beginTransaction();

        try {

            # delete sasaran
            $sasaran = $this->repository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.inpres-sasaran.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Hapus Berhasil.',
                    'message' => 'Sasaran Inpres berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
            }

            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.inpres-sasaran.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Hapus Gagal.',
                        'message' => 'Sasaran Inpres tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            return redirect()
                ->route('admin.sasaran-inpres.index')
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
                    ->route('admin.inpres-sasaran.index')
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
