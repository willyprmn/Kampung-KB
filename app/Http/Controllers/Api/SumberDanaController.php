<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\SumberDanaRepository;

class SumberDanaController extends Controller
{
    protected $repository;

    public function __construct(SumberDanaRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $sumberDanas = $this->repository->get();
        return response()->json($sumberDanas);
    }
}
