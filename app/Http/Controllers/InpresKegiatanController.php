<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contract\InpresKegiatanRepository;

class InpresKegiatanController extends Controller
{

    protected $repository;

    public function __construct(InpresKegiatanRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            if (!empty($request->inpres_program_id)) {
                $desas = $this->repository
                    ->where('inpres_program_id', $request->inpres_program_id)
                    ->get()->pluck('name', 'id');

                return response()->json($desas);
            }
        }

        abort(404);

    }
}
