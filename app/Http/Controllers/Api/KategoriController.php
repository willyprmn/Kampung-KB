<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\KategoriRepository;
use App\Http\Resources\Kategori as KategoriResource;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected $repository;

    public function __construct(KategoriRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $kategories = $this->repository->get();
        return KategoriResource::collection($kategories);
    }
}
