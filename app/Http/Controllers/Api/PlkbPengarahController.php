<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\PlkbPengarahRepository;
use Illuminate\Http\Request;

class PlkbPengarahController extends Controller
{

    protected $repository;

    public function __construct(PlkbPengarahRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $pengarahs = $this->repository->get();
        return response()->json($pengarahs);
    }
}
