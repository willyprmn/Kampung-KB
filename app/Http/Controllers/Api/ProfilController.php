<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\ProfilRepository;

class ProfilController extends Controller
{

    protected $repository;

    public function __construct(ProfilRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        $profils = $this->repository->paginate();
        return response()->json($profils);
    }


    public function show($id)
    {
        $profil = $this->repository->find($id);
        return response()->json($profil);
    }
}
