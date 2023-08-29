<?php

namespace App\View\Components\Chart;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use ZingChart\PHPWrapper\ZC;
use App\Repositories\Criteria\Penduduk\RangePivotCriteria as PendudukRangePivotCriteria;
use App\Repositories\Contract\{
    KampungRepository,
    PendudukRepository,
    RangeRepository,
};


class KelompokUsia extends Component
{
    public $chart;
    public $penduduk;

    protected $kampungRepository,
        $pendudukRepository,
        $rangeRepository
        ;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        RangeRepository $rangeRepository,
        PendudukRepository $pendudukRepository,
        $kampung
    ) {

        $this->pendudukRepository = $pendudukRepository;
        $this->rangeRepository = $rangeRepository;

        $this->pendudukRepository->pushCriteria(PendudukRangePivotCriteria::class);
        $this->penduduk = $this->pendudukRepository
            ->with([
                'penduduk_ranges',
                'keluargas' => function ($keluarga) { return $keluarga->withPivot('jumlah'); }
            ])
            ->findWhere(['is_active' => true, 'kampung_kb_id' => $kampung->id])
            ->first();

	if (!empty($this->penduduk->ranges)) {
            $this->chart = $this->chart($kampung->id);
	}
    }

    private function chart($id){


        $maleJumlah = $this->penduduk->ranges
            ->filter(function ($range) {
                return $range->pivot->jenis_kelamin == 'P';
            })
            ->pluck('pivot.jumlah');
            ;

        $femaleJumlah = $this->penduduk->ranges
            ->filter(function ($range) {
                return $range->pivot->jenis_kelamin == 'W';
            })
            ->pluck('pivot.jumlah');
            ;

        $ages = $this->penduduk->ranges->mapToGroups(function ($range) {
            return [str_replace(' Tahun', '', $range->name) => null];
        })->keys();

        $chart = new ZC("chartKelompokUsia", "pop-pyramid", "light", "700", "100%");

        $max = $maleJumlah->merge($femaleJumlah)->max();

        //json config
        $config = [
            "type" => "pop-pyramid",
            "globals" => [
                "fontSize" => "14px"
            ],
            "options" => [
                "aspect" => "hbar"
            ],
            "legend" => [
                "shared" => true
            ],
            "plot" => [
                "stacked" => true,
                "tooltip" => [
                    "padding" => "10px 15px",
                    "borderRadius" => "3px"
                ],
                "animation" => [
                    "effect" => "ANIMATION_EXPAND_BOTTOM",
                    "method" => "ANIMATION_STRONG_EASE_OUT",
                    "sequence" => "ANIMATION_BY_NODE",
                    "speed" => 222
                ]
            ],
            "scaleX" => [
                "label" => [
                    "text" => "Age Groups"
                ],
                "values" => $ages,
            ],
            "scaleY" => [
                "label" => [
                    "text" => "Population"
                ],
                // "short" => true,
                "values" => "0:{$max}" # min:max:step
            ],
            "series" => [
                [
                    "text" => "Male",
                    "values" => $maleJumlah,
                    "backgroundColor" => "#64b5f6",
                    "dataSide" => 1
                ],
                [
                    "text" => "Female",
                    "values" => $femaleJumlah,
                    "backgroundColor" => "#fe676b",
                    "dataSide" => 2
                ]
            ]
        ];

        if (request()->has('debug')) dd(
            ['maleJumlah' => $maleJumlah],
            ['femaleJumlah' => $femaleJumlah],
            ['ages' => $ages->toArray()],
            ['config' => json_encode($config)]
        );

        $chart->trapdoor(json_encode($config));
        $chart->setChartHeight("700");
        $chart->setChartWidth("100%");

        return $chart;
    }



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.chart.kelompok-usia');
    }
}
