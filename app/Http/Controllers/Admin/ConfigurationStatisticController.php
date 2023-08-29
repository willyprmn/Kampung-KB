<?php

namespace App\Http\Controllers\Admin;

use Log;
use DB;
use App\Http\Controllers\Controller;
use App\Repositories\Contract\{
    ConfigurationStatisticRepository,
};
use App\Http\Requests\Admin\ConfigurationStatistic\{
    UpdateRequest
};

class ConfigurationStatisticController extends Controller
{
    protected $configurationStatisticRepository;

    public function __construct(ConfigurationStatisticRepository $configurationStatisticRepository)
    {
        $this->configurationStatisticRepository = $configurationStatisticRepository;
    }

    public function index()
    {
        $configurations = $this->configurationStatisticRepository->orderBy('id')->get();

        return view('admin.tooltip-statistic.index', compact('configurations'));
    }

    public function update(UpdateRequest $request)
    {
        # Default alert
        $alert = [
            'variant' => 'success',
            'title' => 'Berhasil.',
            'message' => 'Berhasil disimpan.'
        ];
        DB::beginTransaction();

        try {
            $input = $request->all();
            foreach ($input['statistiks'] as $key => $item) {

                $this->configurationStatisticRepository->update($item, $item['id']);

            }

            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('alert', [
                    'variant' => 'danger',
                    'title' => 'Update Gagal.',
                    'message' => 'Mohon maaf, terjadi kesalahan pada server, silahkan hubungi admin'
                ]);
            if (config('app.env') === 'production') {
                Log::error(__METHOD__ . ':' . $e->getMessage());

            }

            report($e);
        }
        return redirect()
                ->route("admin.configuration.tooltip-statistik")
                ->with('alert', $alert);
    }

}
