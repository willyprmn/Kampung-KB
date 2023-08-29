<?php

namespace App\Http\Controllers\Admin\Kampung;

use Auth;
use DB;
use Gate;
use Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\{
    KabupatenRepository,
    KampungRepository,
    UserRepository
};

use App\DataTables\Admin\{
    Kampung\PercontohanDataTable
};

class PercontohanController extends Controller
{

    protected $dataTable;
    protected $kabupatenRepository;
    protected $kampungRepository;

    public function __construct(PercontohanDataTable $dataTable,
        KabupatenRepository $kabupatenRepository,
        KampungRepository $kampungRepository)
    {
        $this->dataTable = $dataTable;
        $this->kabupatenRepository = $kabupatenRepository;
        $this->kampungRepository = $kampungRepository;
    }

    public function index()
    {

        Gate::authorize('any-percontohan');
        $provinsi_id = Auth::user()->provinsi_id;
        return $this->dataTable->render('admin.kampung.percontohan.index', compact('provinsi_id'));
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();

        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Update Berhasil.',
            'message' => 'Percontohan kampung KB berhasil disimpan.'
        ];

        DB::beginTransaction();

        try {

            $kampung = $this->kampungRepository->find($id);

            # get count kabupaten by provinsi
            $count = $this->kabupatenRepository
                ->whereRaw("left(id, 2) = '{$kampung->provinsi_id}'")
                ->get()
                ->count();

            # get count flaging percontohan kabupaten
            $countFlagKabupaten = $this->kampungRepository
                ->where('provinsi_id', $kampung->provinsi_id)
                ->where('contoh_kabupaten_flag', true)
                ->get()
                ->count();

            # get count flaging percontohan provinsi
            $countFlagProvinsi = $this->kampungRepository
                ->where('provinsi_id', $kampung->provinsi_id)
                ->where('contoh_provinsi_flag', true)
                ->get()
                ->count();

            switch(true){
                #kabupaten set true
                case ($countFlagKabupaten < $count) && (isset($request['percontohan']) && $request['percontohan'] === 'kabupaten') :
                    #check exists flaging before update,
                    $check = $this->kampungRepository
                        ->where('provinsi_id', $kampung->provinsi_id)
                        ->where('kabupaten_id', $kampung->kabupaten_id)
                        ->where('contoh_kabupaten_flag', true)
                        ->with(['kabupaten'])
                        ->get();
                    if($check->count() === 1){
                        return back()
                            ->withInput()
                            ->with('alert', [
                                'variant' => 'danger',
                                'title' => 'Update Gagal.',
                                'message' => "Sudah terdapat Kampung KB yang dijadikan percontohan pada kabupaten {$check[0]->kabupaten->name}"
                            ]);
                    }

                    $input = [
                        'contoh_kabupaten_flag' => true
                    ];
                    $this->kampungRepository->update($input, $id);
                    break;

                #redirect when flaging kabupaten is equal with master
                case ($countFlagKabupaten < $count) && (isset($request['percontohan']) && $request['percontohan'] === 'kabupaten') :
                    return back()
                        ->withInput()
                        ->with('alert', [
                            'variant' => 'danger',
                            'title' => 'Update Gagal.',
                            'message' => 'Percontohan kabupaten telah melibihi dari jumlah master kabupaten'
                        ]);
                    break;

                #provinsi set true
                case ($countFlagProvinsi === 0) && (isset($request['percontohan']) && $request['percontohan'] === 'provinsi') :
                    #check exists flaging before update,
                    $check = $this->kampungRepository
                        ->where('provinsi_id', $kampung->provinsi_id)
                        ->where('contoh_provinsi_flag', true)
                        ->with(['kabupaten'])
                        ->get();
                    if($check->count() === 1){
                        return back()
                            ->withInput()
                            ->with('alert', [
                                'variant' => 'danger',
                                'title' => 'Update Gagal.',
                                'message' => "Sudah terdapat Kampung KB yang dijadikan percontohan pada kabupaten {$check[0]->kabupaten->name}"
                            ]);
                    }

                    $input = [
                        'contoh_provinsi_flag' => true
                    ];
                    $this->kampungRepository->update($input, $id);
                    break;

                #redirect when flaging provinsi already exists
                case ($countFlagProvinsi > 0) && (isset($request['percontohan']) && $request['percontohan'] === 'provinsi') :
                    return back()
                        ->withInput()
                        ->with('alert', [
                            'variant' => 'danger',
                            'title' => 'Update Gagal.',
                            'message' => 'Sudah terdapat percontohan provinsi'
                        ]);
                    break;

                #percontohan set false
                case isset($request['batal']) :
                    $input = [
                        $request['batal'] => null
                    ];
                    $this->kampungRepository->update($input, $id);
                    break;
                default :
                    break;
            }

            DB::commit();

            return redirect()
                ->route('admin.percontohan.index')
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
}
