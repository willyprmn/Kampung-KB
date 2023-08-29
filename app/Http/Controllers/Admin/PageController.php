<?php

namespace App\Http\Controllers\Admin;

use Log;
use DB;
use Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Services\StaticConfig;
use App\Repositories\Contract\{
    PageRepository
};

use App\Http\Requests\Admin\Configuration\{
    UpdateRequest
};

class PageController extends Controller
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }


    public function index()
    {

        $page = $this->pageRepository->where('type', 'about')->first();
        $image = null;
        if (Storage::exists($page->image)) {
            $image['base64'] = 'data:image/' . \File::extension($page->image) . ';base64,' . base64_encode(Storage::get($page->image));
        }
        return view('admin.about.index', compact('page', 'image'));
    }

    public function header()
    {

        $conf = StaticConfig::read('home.video');

        $page = $this->pageRepository->where('type', 'header')->first();
        $image = null;
        if (Storage::exists($page->image)) {
            $image['base64'] = 'data:image/' . \File::extension($page->image) . ';base64,' . base64_encode(Storage::get($page->image));
        }
        return view('admin.header.index', compact('page', 'image', 'conf'));
    }

    public function update(Request $request)
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

            if (isset($request->image) && empty($request->image['base64'])) {
                unset($input['image']);
            }

            if (isset($request->image) && !empty($request->image['base64'])) {
                $directory = 'public' . DIRECTORY_SEPARATOR . 'portal' . DIRECTORY_SEPARATOR;
                $base64 = $request->image['base64'];
                $ext = explode('/', mime_content_type($base64))[1];
                $path = $directory . $request->type . '.' . $ext;
                $img = Image::make(file_get_contents($base64))
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->stream($ext, 90);

                Storage::put($path, $img);
                $input = $request
                    ->merge(['image' => $path])
                    ->all();
            }

            if ($request->src === 'file' && $request->hasFile('video')) {
                $video = $request->file('video');
                $filename = "video.{$video->extension()}";
                $path = collect(['public', 'portal'])->join(DIRECTORY_SEPARATOR);
                $video->storeAs($path, $filename);
                StaticConfig::write(
                    'home.video',
                    ['source' => 'file', 'value' => $path . DIRECTORY_SEPARATOR . $filename]
                );
            } elseif (!empty($request->video) && $request->src === 'url') {
                StaticConfig::write(
                    'home.video',
                    [
                        'source' => 'url',
                        'value' => $request->video
                    ]
                );
            }

            $this->pageRepository->skipCache();
            $page = $this->pageRepository->where('type', $request->type)->first();
            $this->pageRepository->update($input, $page->id);

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
                ->route("admin.page.{$request->type}")
                ->with('alert', $alert);
    }

}
