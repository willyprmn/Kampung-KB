<?php

namespace App\View\Components\Chart;

use Illuminate\View\Component;
use ZingChart\PHPWrapper\ZC;
use App\Repositories\Contract\KkbpkRepository;


class PusKb extends Component
{

    public $chartKb, $chartNonKb;
    public $sumKb = 0, $sumNonKb = 0;
    protected $kkbpkRepository
        ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        KkbpkRepository $kkbpkRepository,
        $kampung
    ) {

        $kkbpk = $kkbpkRepository
            ->with([
                'kontrasepsis' => function ($kontrasepsi) {
                    return $kontrasepsi->withPivot('jumlah');
                },
                'non_kontrasepsis' => function ($non_kontrasepsi) {
                    return $non_kontrasepsi->withPivot('jumlah');
                },
            ])
            ->findWhere([
                'is_active' => true,
                'kampung_kb_id' => $kampung->id
            ])
            ->first()
            ;


        if (empty($kkbpk))  return;

        $kbSum = 0;
        $this->chartKb = $this->chart($kkbpk->kontrasepsis, 'chartKb', $kbSum);
        $this->sumKb = $kbSum;

        $nonKbSum = 0;
        $this->chartNonKb = $this->chart($kkbpk->non_kontrasepsis, 'chartNonKb', $nonKbSum);
        $this->sumNonKb = $nonKbSum;
    }

    private function chart($collection, $selector, &$sum = 0)
    {

        $sum = $collection->sum('pivot.jumlah');
        $datas = $collection->map(function ($item) {
            $title = $item->name;
            $color = null;
            switch ($item->alias){
                case 'hamil' : 
                    $title = 'Hamil';
                    $color = "#007bff"; #biru
                    break;
                case 'anak_segera' : 
                    $title = 'IAS';
                    $color = "#20c997"; #hijau
                    break;
                case 'anak_kemudian' : 
                    $title = 'IAT';
                    $color = "#fd7e14"; #orange
                    break;
                case 'tidak_ingin_anak' : 
                    $title = 'TIAL';
                    $color = "#dc3545"; #merah
                    break;
                default : 
                    $item->name;
            }
            if(!empty($color)){ #tidak KB
                return [
                    'text' => $title ?? 'n/a',
                    'values' => [$item->pivot->jumlah ?? 0],
                    'background-color' => $color
                    // 'detached' => true,
                ];
            }
            else{ #pakai KB
                return [
                    'text' => $title ?? 'n/a',
                    'values' => [$item->pivot->jumlah ?? 0],
                ];
            }
        });

        $config = [
            'type' => 'pie3d',
            'plot' => ["offset-r" => "2%"],
            // 'legend' => ['dragable' => true],
            'series' => $datas
        ];

        $chart = new ZC($selector, "hbar", "light", "700", "100%");

        $chart->trapdoor(json_encode($config));
        $chart->setChartHeight("350");
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
        return view('components.chart.pus-kb');
    }
}
