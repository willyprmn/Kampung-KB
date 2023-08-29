<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\JenisPostRepository;
use App\Http\Resources\JenisPost as JenisPostResource;
use Illuminate\Http\Request;

class JenisPostController extends Controller
{

    protected $repository;

    public function __construct(JenisPostRepository $repository)
    {

        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $jenisPosts = $this->repository->get();
        return JenisPostResource::collection($jenisPosts);
    }
}
