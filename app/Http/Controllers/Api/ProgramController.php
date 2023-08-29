<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\ProgramRepository;
use App\Repositories\Criteria\Program\PoktanCriteria;
use App\Http\Resources\Program as ProgramResource;

class ProgramController extends Controller
{

    protected $repository;

    public function __construct(ProgramRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $programs = $this->repository->get();
        return response()->json($programs);
    }
}
