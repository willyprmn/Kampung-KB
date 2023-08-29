<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\InstansiRepository;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    protected $repository;

    public function __construct(InstansiRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $instansis = $this->repository->get();
        return response()->json($instansis);
    }
}
