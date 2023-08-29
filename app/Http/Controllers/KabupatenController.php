<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contract\KabupatenRepository;

class KabupatenController extends Controller
{

    protected $kabupatenRepository;

    public function __construct(KabupatenRepository $kabupatenRepository)
    {

        $this->kabupatenRepository = $kabupatenRepository;
    }


    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            if (!empty($request->provinsi_id)) {
                $kabupatens = $this->kabupatenRepository
                    ->where('id', 'like', "{$request->provinsi_id}%")
                    ->orderBy('id')
                    ->get()->pluck('name', 'id');
                return response()->json($kabupatens);
            }

            $kabupatens = $this->kabupatenRepository->paginate($request->limit);
            return response()->json($kabupatens);
        }

        abort(404);
    }
}
