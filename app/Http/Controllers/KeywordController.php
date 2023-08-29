<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contract\KeywordRepository;

class KeywordController extends Controller
{

    protected $repository;

    public function __construct(KeywordRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            if ($request->has('keyword')) {
                $keywords = $this->repository
                    ->where('inpres_program_id', $request->inpres_program_id)
                    ->get()
                    ->pluck('name', 'id');

                return response()->json($keywords);
            }
        }

        abort(404);
    }
}
