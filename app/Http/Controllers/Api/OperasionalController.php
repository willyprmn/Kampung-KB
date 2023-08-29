<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\OperasionalRepository;


class OperasionalController extends Controller
{

    protected $repository;

    public function __construct(OperasionalRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index()
    {

        $operasionals = $this->repository->get();
        return response()->json($operasionals);
    }
}
