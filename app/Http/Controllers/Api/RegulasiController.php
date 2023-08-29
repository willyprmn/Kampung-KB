<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\RegulasiRepository;

class RegulasiController extends Controller
{

    protected $repository;


    public function __construct(RegulasiRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index()
    {

        $regulasis = $this->repository->get();
        return response()->json($regulasis);
    }
}
