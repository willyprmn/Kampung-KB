<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\FrekuensiRepository;

class FrekuensiController extends Controller
{
    protected $repository;

    public function __construct(FrekuensiRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index()
    {

        $frekuensis = $this->repository->get();
        return response()->json($frekuensis);
    }
}
