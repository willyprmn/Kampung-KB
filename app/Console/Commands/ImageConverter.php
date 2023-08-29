<?php

namespace App\Console\Commands;

use Log;
use Storage;


use Illuminate\Console\Command;
use App\Services\KampungService;
use App\Models\Kampung;
use App\Models\IntervensiGambar;
use App\Repositories\Contract\KampungRepository;
use Intervention\Image\ImageManagerStatic as Image;


class ImageConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $backupPath = '/Volumes/BACKUP DB SIGA/KP KB Image';
    protected $counter = 0;
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(KampungService $kampungService)
    {
        parent::__construct();
        $this->service = $kampungService;
    }

    protected function next()
    {
        $this->counter += 1;
        return $this->counter;
    }

    protected function convert($source)
    {
        $originalFile = str_replace('uploads', $this->backupPath, $source);
        $ext = pathinfo($originalFile)['extension'];
        $img = Image::make(file_get_contents($originalFile))
            ->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->stream($ext, 90)
            ;

        file_put_contents(public_path($source), $img);
    }

    protected function mapKampung($source, $target, $filename)
    {
        $originalFile = str_replace('uploads', $this->backupPath, $source);
        $ext = pathinfo($originalFile)['extension'];
        $img = Image::make(file_get_contents($originalFile))
            ->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->stream($ext, 90)
            ;

        $path = "{$target}{$filename}.{$ext}";

        Storage::put($path, $img);

        return $path;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if (config('app.env') === 'production') {
            return Log::error('THIS DANGEROUS COMMAND CANNOT BE EXECUTED ON PRODUCTION...!!!');
        }

        Kampung::with(['intervensis.intervensi_gambars'])
            // ->where('id', '>', 1274)
            ->orderBy('id')
            ->chunk(500, function ($kampungs) {

            foreach ($kampungs as $kampung) {

                $target = $this->service->generateKampungPath($kampung, 'public');

                try {

                    $oldGambar = $kampung->path_gambar;
                    $kampung->path_gambar = $this->mapKampung($kampung->path_gambar, $target, 'gambar') ?? null;

                } catch (\Intervention\Image\Exception\NotReadableException $e) {
                    Log::error($kampung->id . ' : ' . $kampung->id . ' : ' . $e->getMessage());
                    $this->error($kampung->id . ' : ' . $e->getMessage());
                } catch (\ErrorException $e) {
                    Log::error($kampung->id . ' : ' . $e->getMessage());
                    $this->error($target . ': '  . $kampung->id . ' : ' . 'gambar' . ' : ' . $oldGambar . ' : '. $e->getMessage());
                }


                try {

                    $oldStruktur = $kampung->path_struktur;
                    $kampung->path_struktur = $this->mapKampung($kampung->path_struktur, $target, 'struktur') ?? null;

                } catch (\Intervention\Image\Exception\NotReadableException $e) {
                    Log::error($kampung->id . ' : ' . $e->getMessage());
                    $this->error($kampung->id . ' : ' . $e->getMessage());
                } catch (\ErrorException $e) {
                    Log::error($kampung->id . ' : ' . $e->getMessage());
                    $this->error($target . ': '  . $kampung->id . ' : ' . 'struktur' . ' : ' . $oldStruktur . ' : '. $e->getMessage());
                }

                $kampung->save();

                foreach ($kampung->intervensis ?? [] as $intervensi) {
                    foreach ($intervensi->intervensi_gambars ?? [] as $gambar) {

                        try {

                            $oldGambar = $gambar->path;
                            $intervensiTarget = $target . $this->service->generateIntervensiPath($intervensi);
                            $gambar->path = $this->mapKampung($gambar->path, $intervensiTarget, $gambar->id) ?? null;
                            $gambar->save();

                        } catch (\Intervention\Image\Exception\NotReadableException $e) {
                            Log::error($kampung->id . ' : ' . $e->getMessage());
                            $this->error($kampung->id . ' : ' . $e->getMessage());
                        } catch (\ErrorException $e) {
                            Log::error($kampung->id . ' : ' . $e->getMessage());
                            $this->error($intervensiTarget . ': '  . $gambar->id . ' : ' . 'intervensi' . ' : ' . $oldGambar . ' : '. $e->getMessage());
                        }

                    }
                }
            }



            $next = $this->next();
            Log::info('Batch ' . $next);
            $this->info('Batch ' . $next);
            // exit;

        });
    }
}
