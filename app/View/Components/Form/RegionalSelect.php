<?php

namespace App\View\Components\Form;

use Auth;
use App\Repositories\Contract\{
    DesaRepository,
    KabupatenRepository,
    KecamatanRepository,
    ProvinsiRepository
};
use Illuminate\View\Component;

class RegionalSelect extends Component
{

    protected $client;
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
        $client = null
    ) {

        $this->desaRepository = $desaRepository;
        $this->kabupatenRepository = $kabupatenRepository;
        $this->kecamatanRepository = $kecamatanRepository;
        $this->provinsiRepository = $provinsiRepository;
        $this->client = $client;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        $client = $this->client;

        $provinsis = $kabupatens = $kecamatans = $desas = [];

        $provinsiId = old('provinsi_id') ?? Auth::user()->provinsi_id ?? $client->provinsi_id ?? null;
        $kabupatenId = old('kabupaten_id') ?? Auth::user()->kabupaten_id ?? $client->kabupaten_id ?? null;
        $kecamatanId = old('kecamatan_id') ?? Auth::user()->kecamatan_id ?? $client->kecamatan_id ?? null;
        $desaId = old('desa_id') ?? Auth::user()->desa_id ?? $client->desa_id ?? null;


        $provinsis = $this->provinsiRepository
                ->get()->sortBy('id')->pluck('name', 'id');

        if (!empty($provinsiId)) {
            $kabupatens = $this->kabupatenRepository
                ->where('id', 'like', $provinsiId . '%')
                ->orderBy('id')
                ->get()
                ->pluck('name', 'id');


            if (!empty($kabupatenId)) {
                $kecamatans = $this->kecamatanRepository
                    ->where('id', 'like', $kabupatenId . '%')
                    ->orderBy('id')
                    ->get()
                    ->pluck('name', 'id');

                if (!empty($kecamatanId)) {
                    $desas = $this->desaRepository
                        ->where('id', 'like', $kecamatanId . '%')
                        ->orderBy('id')
                        ->get()
                        ->pluck('name', 'id');
                }
            }
        }

        return view('components.form.regional-select', compact(
            'client',
            'provinsis', 'provinsiId',
            'kabupatens', 'kabupatenId',
            'kecamatans', 'kecamatanId',
            'desas', 'desaId'
        ));
    }
}
