<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contract\DesaRepository;

class DesaController extends Controller
{

    protected $desaRepository;

    public function __construct(DesaRepository $desaRepository)
    {

        $this->desaRepository = $desaRepository;
    }


    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            if (!empty($request->kecamatan_id)) {
                $desas = $this->desaRepository
                    ->where('id', 'like', "{$request->kecamatan_id}%")
                    ->orderBy('id')
                    ->get()->pluck('name', 'id');
                return response()->json($desas);
            }

            $desas = $this->desaRepository->paginate($request->limit);
            return response()->json($desas);
        }

        abort(404);
    }
}
