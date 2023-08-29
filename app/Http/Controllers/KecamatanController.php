<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contract\KecamatanRepository;

class KecamatanController extends Controller
{

    protected $kecamatanRepository;

    public function __construct(KecamatanRepository $kecamatanRepository)
    {

        $this->kecamatanRepository = $kecamatanRepository;
    }


    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            if (!empty($request->kabupaten_id)) {
                $kecamatans = $this->kecamatanRepository
                    ->where('id', 'like', "{$request->kabupaten_id}%")
                    ->orderBy('id')
                    ->get()->pluck('name', 'id');
                return response()->json($kecamatans);
            }

            $kecamatans = $this->kecamatanRepository->paginate($request->limit);
            return response()->json($kecamatans);
        }

        abort(404);
    }
}
