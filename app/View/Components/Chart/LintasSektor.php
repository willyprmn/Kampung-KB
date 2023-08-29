<?php

namespace App\View\Components\Chart;

use Cache;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use ZingChart\PHPWrapper\ZC;
use App\Models\Intervensi;
use App\Repositories\Contract\{
    KampungRepository,
    RangeRepository,
    InstansiRepository,
    IntervensiRepository
};

class LintasSektor extends Component
{
    public $chart;
    protected $kampungTotal;
    protected $kampungRepository;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        KampungRepository $kampungRepository,
        InstansiRepository $instansiRepository,
        IntervensiRepository $intervensiRepository,
        int $kampungTotal
    ) {

        $this->kampungRepository = $kampungRepository;
        $this->instansiRepository = $instansiRepository;
        $this->intervensiRepository = $intervensiRepository;
        $this->kampungTotal = $kampungTotal;

        // $key = md5(json_encode(__METHOD__ . request()->url()));
        // $this->chart = Cache::remember($key, 300, function () {
            // return $this->chart();
        // });
    }

    private function chart()
    {

        $datas = array();

        $data = DB::select(
            "SELECT c_crosstab('
                select * from (

                    select a.provinsi_id, d.name, cast(count(d.name) as integer) jumlah
                    from new_kampung_kb a
                    inner join new_intervensi b on a.id = b.kampung_kb_id
                    inner join new_intervensi_instansi c on b.id = c.intervensi_id
                    left join new_instansi d on c.instansi_id = d.id
                    inner join new_provinsi e on a.provinsi_id = e.id
                    group by a.provinsi_id, d.name
                    order by 1, 2

                ) a
                ', 'ct_view', 'provinsi_id', 'name', 'jumlah', 'min', null);
        "
        );

        $data = DB::select("select * from ct_view;");

        //get sum for every column
        $sumTotal = array_sum(array_map(function($sektor) {

                $values = (array)$sektor;
                return $values['total'];

            }, $data)
        );
        if(!empty($data)){
            foreach($data[0] as $key => $item){
                if($key !== 'provinsi_id' && $key !== 'total'){

                    // dd(array_column($data, $key));
                    $sumColumn = array_sum(array_map(function($sektor) use($key) {

                            $values = (array)$sektor;
                            return $values[$key];

                        }, $data)
                    );

                    //get persentase
                    array_push($datas,
                        array(
                            'text' => $key,
                            'values' => [round(($sumColumn/$sumTotal) * 100, 2)]
                        )
                    );
                }
            }
        }
        $keys = array_column($datas, 'values');

		array_multisort($keys, SORT_DESC, $datas);


        dd(array_slice($datas, 0, 5));

        $config = '
        {
            "type": "bar",
            "plot": {
                "offset-r": "1%"
            },
            "series": ' . json_encode(array_slice($datas, 0, 15)) . '
        }';

        $chart = new ZC("chartLintasSektor", "hbar", "light", "900", "100%");

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

        $instansis = Cache::tags([Intervensi::class])->remember(__METHOD__, 300, function () {
            return $this->intervensiRepository
                ->select([
                    DB::raw('COUNT(DISTINCT new_intervensi.kampung_kb_id) AS intervensis_count'),
                    'new_instansi.name',
                ])
                ->join('new_intervensi_instansi', 'new_intervensi_instansi.intervensi_id', '=', 'new_intervensi.id')
                ->join('new_kampung_kb', function ($join) {
                    $join->on('new_kampung_kb.id', '=', 'new_intervensi.kampung_kb_id')
                        ->where('new_kampung_kb.is_active', true)
                        ;
                })
                ->join('new_instansi', 'new_instansi.id', '=', 'new_intervensi_instansi.instansi_id')
                ->groupBy('new_instansi.name')
                ->orderBy('intervensis_count', 'DESC')
                ->limit(15)
                ->get()
                ->map(function ($instansi) {
                    $instansi->keterlibatan = round($instansi->intervensis_count / $this->kampungTotal * 100, 2);
                    return $instansi;
                });
        });

        $config = '{
            "type": "hbar",
            "plot": {
                "offset-r": "1%"
            },
            "guide": {
                "lineStyle": "solid"
            },
            "scaleX": {
                "values": ' . $instansis->pluck('name')->toJson() . '
            },
            "series": [
                {
                    "values": ' . $instansis->pluck('keterlibatan')->toJson() . ',
                    "text": "persentase (%)"
                }
            ]
        }';

        $chart = new ZC("chartLintasSektor");
        $chart->trapdoor($config);
        $chart->setChartHeight("500");
        $chart->setChartWidth("100%");
        $this->chart = $chart;

        return view('components.chart.lintas-sektor');
    }
}
