<?php

namespace App\Http\Controllers\Api;

use Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\KampungRepository;
use App\Repositories\Criteria\Kampung\LocationCriteria as KampungLocationCriteria;


class KampungController extends Controller
{

    protected $repository;

    public function __construct(KampungRepository $kampungRepository)
    {
        $this->repository = $kampungRepository;
    }

    public function index()
    {

        $this->repository->pushCriteria(KampungLocationCriteria::class);
        $kampungs = $this->repository
            ->where('latitude', '<>', null)
            ->where('longitude', '<>', null)
            ->get();

        $kampungs->map(function ($kampung) {
            $kampung->setAttribute('url', route('portal.kampung.show', [
                'kampung_id' => $kampung->id,
                'slug' => Str::slug($kampung->nama),
            ]));
            return $kampung;
        });

        return $kampungs;
        // return response()->json('bodoh');
        return response()->json($kampungs);
    }
}
