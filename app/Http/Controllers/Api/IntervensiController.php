<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\IntervensiRepository;

class IntervensiController extends Controller
{

    protected $repository;


    public function __construct(IntervensiRepository $repository)
    {

        $this->repository = $repository;
    }

    public function show(Request $request, $id)
    {

        $intervensi = $this->repository->find($id);
        return response()->json($intervensi);
    }
}
