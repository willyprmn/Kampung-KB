<?php

namespace App\View\Components\Chart;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use ZingChart\PHPWrapper\ZC;
use App\Repositories\Contract\{
    PendudukRepository,
    KkbpkRepository,
};

class KelompokKegiatan extends Component
{

    const PROGRAM_KELUARGA_MAP = [
        1 => 4,
        2 => 5,
        3 => 6,
        4 => 2,
        5 => 3,
    ];

    public $chart;

    public $balita;
    public $remaja;
    public $lansia;
    public $memiliki_remaja;

    protected $kkbpkRepository,
        $pendudukRepository
        ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        KkbpkRepository $kkbpkRepository,
        PendudukRepository $pendudukRepository,
        $kampung
    ) {

        $this->kkbpkRepository = $kkbpkRepository;
        $this->pendudukRepository = $pendudukRepository;

        $this->chart = $this->chart($kampung->id);
    }

    private function chart($id)
    {

        $keluargas = $this->pendudukRepository
            ->with([
                'keluargas' => function ($keluarga) { return $keluarga->withPivot('jumlah'); }
            ])
            ->findWhere([
                'kampung_kb_id' => $id,
                'is_active' => true,
            ])
	    ->first();

	if (empty($keluargas)) return null;

        $keluargas = $keluargas->keluargas
            ->pluck('pivot.jumlah', 'id');

        $this->remaja = $keluargas[3];
        $this->balita = $keluargas[4];
        $this->memiliki_remaja = $keluargas[5];
        $this->lansia = $keluargas[6];

        $programs = $this->kkbpkRepository
            ->with([
                'programs' => function ($program) { return $program->withPivot('jumlah'); }
            ])
            ->findWhere([
                'kampung_kb_id' => $id,
                'is_active' => true,
            ])
            ->first()->programs ?? collect([]);


        $percentage = $programs->mapWithKeys(function ($program) use ($keluargas) {

            if (isset($keluargas[self::PROGRAM_KELUARGA_MAP[$program->id]]) && $keluargas[self::PROGRAM_KELUARGA_MAP[$program->id]] > 1) {
              return [
                  $program->name => round($program->pivot->jumlah / $keluargas[self::PROGRAM_KELUARGA_MAP[$program->id]] * 100, 2)
              ];
            }

            return [$program->name => 0];

        });

        //profil keluarga
        // $keluargas = $this->kampung->penduduk->keluargas;

        // //kkbpk program
        // if(!empty($this->kampung->kkbpk)){

        //   $kkbpk_programs = $this->kampung->kkbpk->kkbpk_programs;

        //   $datas = array();
        //   foreach($kkbpk_programs as $program){

        //       $percentage = 0;

        //       switch ($program->program->name){
        //           case 'BKB' :
        //               $pembagi = $keluargas->where('name', 'Keluarga yang Memiliki Balita')->first()->pivot->jumlah;
        //               $percentage = $program->jumlah / $pembagi;
        //               break;
        //           case 'BKR' :
        //               $pembagi = $keluargas->where('name', 'Keluarga yang Memiliki Remaja')->first()->pivot->jumlah;
        //               $percentage = $program->jumlah / $pembagi;
        //               break;
        //           case 'BKL' :
        //               $pembagi = $keluargas->where('name', 'Keluarga yang Memiliki Lansia')->first()->pivot->jumlah;
        //               $percentage = $program->jumlah / $pembagi;
        //               break;
        //           case 'UPPKS' :
        //               $pembagi = $keluargas->where('name', 'Jumlah Keluarga')->first()->pivot->jumlah;
        //               $percentage = $program->jumlah / $pembagi;
        //               break;
        //           case 'PIK R' :
        //               $pembagi = $keluargas->where('name', 'Jumlah Remaja')->first()->pivot->jumlah;
        //               $percentage = $program->jumlah / $pembagi;
        //               break;
        //           default :
        //               $percentage = 0;
        //               break;
        //       }

        //       $data = [ 'program' => $program->program->name, 'persentase' => round($percentage * 100, 2)];
        //       array_push($datas, $data);

        //   }
        // }else{
        //   $datas = array(
        //     array('program' => 'BKB', 'persentase' => 0),
        //     array('program' => 'BKR', 'persentase' => 0),
        //     array('program' => 'BKL', 'persentase' => 0),
        //     array('program' => 'UPPKS', 'persentase' => 0),
        //     array('program' => 'PIK R', 'persentase' => 0),
        //   );
        // }

        // dd($percentage->keys());
        $programs = $percentage->keys()->implode('","');
        $percentages = $percentage->values()->implode(',');
        // dd($percentages);
        $config = '{
            "type": "hbar",
            "theme": "classic",
            "globals": {
              "fontFamily": "Helvetica"
            },
            "backgroundColor": "white",
            "plot": {
              "hoverState": {
                "border": "2px solid #ffff00"
              },
              "tooltip": {
                "visible": false
              },
              "valueBox": {
                "text": "%v%",
                "color": "#606060",
                "textDecoration": "underline"
              },
              "animation": {
                "effect": "ANIMATION_EXPAND_HORIZONTAL"
              },
              "cursor": "hand",
              "dataBrowser": [
                "<span style=\"font-weight:bold;color:red;\">BKB</span>",
                "<span style=\"font-weight:bold;color:yellow;\">BKR</span>",
                "<span style=\"font-weight:bold;color:purple;\">BKL</span>",
                "<span style=\"font-weight:bold;color:orange;\">UPPKS</span>",
                "<span style=\"font-weight:bold;color:blue;\">PIK-R</span>"
              ],
              "rules": [

                {
                  "backgroundColor": "blue",
                  "rule": "%i==0"
                },
                {
                  "backgroundColor": "orange",
                  "rule": "%i==1"
                },
                {
                  "backgroundColor": "purple",
                  "rule": "%i==2"
                },
                {
                  "backgroundColor": "yellow",
                  "rule": "%i==3"
                },
                {
                  "backgroundColor": "red",
                  "rule": "%i==4"
                }
              ]
            },
            "scaleX": {
              "values": ["' . $programs . '"],
              "guide": {
                "visible": false
              },
              "item": {
                "color": "#606060"
              },
              "lineColor": "#C0D0E0",
              "lineWidth": "1px",
              "tick": {
                "lineColor": "#C0D0E0",
                "lineWidth": "1px"
              }
            },
            "scaleY": {
              "guide": {
                "lineStyle": "solid"
              },
              "item": {
                "color": "#606060"
              },
              "lineColor": "none",
              "tick": {
                "lineColor": "none"
              }
            },
            "crosshairX": {
              "lineColor": "none",
              "lineWidth": "0px",
              "marker": {
                "visible": false
              },
              "plotLabel": {
                "text": "%data-browser: %v% of total",
                "padding": "8px",
                "alpha": 0.9,
                "backgroundColor": "white",
                "borderRadius": "4px",
                "borderWidth": "3px",
                "callout": true,
                "calloutPosition": "bottom",
                "color": "#606060",
                "fontSize": "12px",
                "multiple": true,
                "offsetY": "-20px",
                "placement": "node-top",
                "rules": [
                  {
                    "borderColor": "#1976d2",
                    "rule": "%i==0"
                  },
                  {
                    "borderColor": "#424242",
                    "rule": "%i==1"
                  },
                  {
                    "borderColor": "#388e3c",
                    "rule": "%i==2"
                  },
                  {
                    "borderColor": "#ffa000",
                    "rule": "%i==3"
                  },
                  {
                    "borderColor": "#7b1fa2",
                    "rule": "%i==4"
                  },
                  {
                    "borderColor": "#c2185b",
                    "rule": "%i==5"
                  }
                ],
                "shadow": false
              },
              "scaleLabel": {
                "visible": false
              }
            },
            "series": [
              {
                "values": [' . $percentages . ']
              }
            ]
        }';

        $chart = new ZC("chartKegiatan", "hbar", "light", "700", "100%");

        $chart->trapdoor($config);
        $chart->setChartHeight("500");
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
        return view('components.chart.kelompok-kegiatan');
    }
}
