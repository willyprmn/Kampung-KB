<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\SasaranRepository;
use App\Http\Resources\Sasaran as SasaranResource;
use Illuminate\Http\Request;

class SasaranController extends Controller
{
    protected $repository;

    public function __construct(SasaranRepository $repository)
    {

        $this->repository = $repository;
    }

    public function index(Request $request)
    {

        $sasarans = $this->repository->get();
        return SasaranResource::collection($sasarans);
    }
}
