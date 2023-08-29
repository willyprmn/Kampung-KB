<?php

namespace App\Http\Controllers\Admin\Inpres;

use DB;
use Log;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\Inpres\ProgramDataTable;
use App\Repositories\Contract\{
    InpresSasaranRepository,
    InpresProgramRepository
};
use App\Models\InpresProgram;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    protected $dataTable;
    protected $sasaranRepository;
    protected $programRepository;

    public function __construct(
        ProgramDataTable $dataTable,
        InpresSasaranRepository $sasaranRepository,
        InpresProgramRepository $programRepository
    ) {

        $this->dataTable = $dataTable;
        $this->sasaranRepository = $sasaranRepository;
        $this->programRepository = $programRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        # Policy
        $this->authorize('viewAny', InpresProgram::class);

        return $this->dataTable->render('admin.inpres.program.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        # Policy
        $this->authorize('create', InpresProgram::class);

        $sasarans = $this->sasaranRepository->get()->pluck('name', 'id');
        return view('admin.inpres.program.create', compact('sasarans'));
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
        $this->authorize('create', InpresProgram::class);

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $program = $this->programRepository->create($input);

            DB::commit();

            return redirect()
                ->route('admin.inpres-program.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Tambah Berhasil.',
                    'message' => 'Master Program Inpres berhasil ditambah.'
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
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return \Illuminate\Http\Response
     */
    public function show(InpresProgram $inpresProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        # Policy
        $this->authorize('update', InpresProgram::find($id));

        $sasarans = $this->sasaranRepository->get()->pluck('name', 'id');
        $program = $this->programRepository->find($id);
        return view('admin.inpres.program.edit', compact('sasarans', 'program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        # Policy
        $this->authorize('update', $this->programRepository->find($id));

        $input = $request->all();

        DB::beginTransaction();

        try {

            # Insert new keyword
            $sasaran = $this->programRepository->update($input, $id);

            DB::commit();

            return redirect()
                ->route('admin.inpres-program.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Update Berhasil.',
                    'message' => 'Master Program Inpres berhasil diperbaharui.'
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
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        # Policy
        $this->authorize('delete', $this->programRepository->find($id));

        DB::beginTransaction();

        try {

            # delete sasaran
            $sasaran = $this->programRepository->delete($id);

            DB::commit();

            return redirect()
                ->route('admin.inpres-program.index')
                ->with('alert', [
                    'variant' => 'success',
                    'title' => 'Hapus Berhasil.',
                    'message' => 'Program Inpres berhasil dihapus.'
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());
            }

            if(strpos($e->getMessage(), 'Foreign key violation')){
                return redirect()
                    ->route('admin.inpres-program.index')
                    ->with('alert', [
                        'variant' => 'danger',
                        'title' => 'Hapus Gagal.',
                        'message' => 'Program Inpres tidak dapat dihapus, sudah digunakan pada table lain!'
                    ]
                );
            }
            return redirect()
                ->route('admin.inpres-program.index')
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
