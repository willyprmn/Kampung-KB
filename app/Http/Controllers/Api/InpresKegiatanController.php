<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\InpresKegiatanRepository;
use Illuminate\Http\Request;

class InpresKegiatanController extends Controller
{

    protected $repository;

    public function __construct(InpresKegiatanRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $inpresKegiatans = $this->repository->get();
        return response()->json($inpresKegiatans);
    }
}
