<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\PenggunaanDataRepository;

class PenggunaanDataController extends Controller
{
    protected $repository;


    public function __construct(PenggunaanDataRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index()
    {

        $penggunaanDatas = $this->repository->get();
        return response()->json($penggunaanDatas);
    }
}
