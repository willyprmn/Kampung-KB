<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contract\ProvinsiRepository;

class ProvinsiController extends Controller
{

    protected $provinsiRepository;

    public function __construct(ProvinsiRepository $provinsiRepository)
    {

        $this->provinsiRepository = $provinsiRepository;
    }


    public function index(Request $request)
    {

        $provinsis = $this->provinsiRepository->orderBy('id')->get();
        if ($request->wantsJson()) {
            return response()->json($provinsis->pluck('name', 'id'));
        }
    }
}
