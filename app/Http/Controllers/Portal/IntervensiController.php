<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contract\IntervensiRepository;
use App\Repositories\Contract\KampungRepository;
use App\Repositories\Criteria\Intervensi\Portal\{
    IndexCriteria as IntervensiPortalIndexCriteria,
    ShowCriteria as IntervensiPortalShowCriteria
};
use App\Repositories\Criteria\Kampung\Portal\MinimalCriteria as KampungPortalMinimalCriteria;
use App\Models\{
    Kampung,
    Intervensi
};

class IntervensiController extends Controller
{

    protected $kampungRepository,
        $intervensiRepository
        ;


    public function __construct(
        KampungRepository $kampungRepository,
        IntervensiRepository $intervensiRepository
    ) {

        $this->kampungRepository = $kampungRepository;
        $this->intervensiRepository = $intervensiRepository;
    }


    public function index(Request $request, $kampungId)
    {

        $this->kampungRepository->pushCriteria(KampungPortalMinimalCriteria::class);
        $kampung = $this->kampungRepository->find($kampungId);

        $this->intervensiRepository->pushCriteria(IntervensiPortalIndexCriteria::class);
        $intervensis = $this->intervensiRepository
            ->where(['kampung_kb_id' => $kampungId])
            ->orderBy('tanggal', 'DESC')
            ->simplePaginate();


        return view('portal.intervensi.index', compact('kampung', 'intervensis'));
    }


    public function show(Request $request, $kampungId, $intervensiId)
    {
        $this->intervensiRepository->pushCriteria(IntervensiPortalShowCriteria::class);
        $intervensi = $this->intervensiRepository
            ->find($intervensiId);

        return view('portal.intervensi.show', compact('intervensi'));
    }
}
