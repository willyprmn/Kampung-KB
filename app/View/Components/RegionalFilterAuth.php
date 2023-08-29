<?php

namespace App\View\Components;

use Auth;

use Illuminate\View\Component;
use App\Repositories\Contract\{
    DesaRepository,
    KabupatenRepository,
    KecamatanRepository,
    ProvinsiRepository
};

class RegionalFilterAuth extends Component
{
    protected $tableId;
    protected $desaRepository,
        $kabupatenRepository,
        $kecamatanRepository,
        $provinsiRepository
        ;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        DesaRepository $desaRepository,
        KabupatenRepository $kabupatenRepository,
        KecamatanRepository $kecamatanRepository,
        ProvinsiRepository $provinsiRepository,
        string $tableId
    ) {

        $this->desaRepository = $desaRepository;
        $this->kabupatenRepository = $kabupatenRepository;
        $this->kecamatanRepository = $kecamatanRepository;
        $this->provinsiRepository = $provinsiRepository;

        $this->tableId = $tableId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        $provinsis = $kabupatens = $kecamatans = $desas = [];

        if (!empty(Auth::user()->provinsi_id)) {
            $provinsis = $this->provinsiRepository
                ->findWhere(['id' => Auth::user()->provinsi_id])
                ->pluck('name', 'id');

            if (!empty(Auth::user()->kabupaten_id)) {
                $kabupatens = $this->kabupatenRepository
                    ->findWhere(['id' => Auth::user()->kabupaten_id])
                    ->pluck('name', 'id');

                if (!empty(Auth::user()->kecamatan_id)) {
                    $kecamatans = $this->kecamatanRepository
                        ->findWhere(['id' => Auth::user()->kecamatan_id])
                        ->pluck('name', 'id');

                    if (!empty(Auth::user()->desa_id)) {
                        $desas = $this->desaRepository
                            ->findWhere(['id' => Auth::user()->desa_id])
                            ->pluck('name', 'id');

                    } else {
                        $desas = $this->desaRepository
                            ->where('id', 'like', Auth::user()->kecamatan_id . '%')
                            ->orderBy('id')
                            ->get()->pluck('name', 'id');
                    }
                } else {
                    $kecamatans = $this->kecamatanRepository
                        ->where('id', 'like', Auth::user()->kabupaten_id . '%')
                        ->orderBy('id')
                        ->get()->pluck('name', 'id');
                }
            } else {
                $kabupatens = $this->kabupatenRepository
                    ->where('id', 'like', Auth::user()->provinsi_id . '%')
                    ->orderBy('id')
                    ->get()->pluck('name', 'id');
            }
        } else {
            $provinsis = $this->provinsiRepository
                ->orderBy('id')
                ->get()->pluck('name', 'id');
        }

        $tableId = $this->tableId;
        return view('components.regional-filter-auth', compact(
            'provinsis',
            'kabupatens',
            'kecamatans',
            'desas',
            'tableId'
        ));
    }
}
