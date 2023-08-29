<?php

namespace App\Http\Controllers\Portal;

use Cache;
use Storage;
use DB;
use Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StaticConfig;
use App\Repositories\Contract\{
    KampungRepository,
    PageRepository,
    IntervensiRepository,
};
use App\Repositories\Criteria\Kampung\{
    WilayahCriteria,
};

use App\DataTables\Portal\PercontohanDataTable;

class PageController extends Controller
{
    protected $kampungRepository;
    protected $pageRepository;
    protected $dataTable;

    public function __construct(
        KampungRepository $kampungRepository,
        PageRepository $pageRepository,
        PercontohanDataTable $dataTable,
        IntervensiRepository $intervensiRepository
    ) {
        $this->kampungRepository = $kampungRepository;
        $this->pageRepository = $pageRepository;
        $this->intervensiRepository = $intervensiRepository;
        $this->dataTable = $dataTable;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {

        $conf = StaticConfig::read('home.video');

        $kampung_total = $this->kampungRepository->count();

        $this->kampungRepository->pushCriteria(WilayahCriteria::class);
        $kampung_terupdate = $this->kampungRepository->orderBy('updated_at', 'desc')
            ->with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])
            ->limit(4);

        $kampung_terpilih = $this->kampungTerpilih();

        $page = $this->pageRepository->where('type', 'header')->first();
        $image = !empty($page->image) ? Storage::url($page->image) : asset('images/hero.webp');

        return view('portal.page.home', compact('conf', 'kampung_total', 'kampung_terpilih', 'kampung_terupdate', 'page', 'image'));
    }


    public function about()
    {
        $page = $this->pageRepository->where('type', 'about')->first();
        $image = ['base64' => asset('images/default-intervensi.png')];
        if (Storage::exists($page->image)) {
            $image['base64'] = url(Storage::url($page->image));
        }
        return view('portal.page.about', compact('page', 'image'));
    }

    public function percontohan()
    {
        return $this->dataTable->render('portal.page.percontohan');
    }

    private function kampungTerpilih()
    {

        $sql = "select
                a.id,
                a.nama,
                f.name provinsi,
                g.name kabupaten,
                h.name kecamatan,
                i.name desa,
                TO_CHAR(a.tanggal_pencanangan:: DATE, 'Mon dd, yyyy') tanggal_pencanangan,
                path_gambar
            from new_kampung_kb a
            inner join (
                select kampung_kb_id, count(1) jumlah_intervensi
                from new_intervensi
                group by kampung_kb_id
                order by count(1) desc
            ) b on a.id = b.kampung_kb_id
            inner join (
                select kampung_kb_id, count(1) jumlah_kkbpk
                from new_kkbpk_kampung
                group by kampung_kb_id
                order by count(1) desc
            ) c on a.id = c.kampung_kb_id
            inner join (
                select ROW_NUMBER () OVER (ORDER BY created_at desc) , *
                from new_penduduk_kampung
                where is_active is true
                order by created_at desc
            ) d on a.id = d.kampung_kb_id
            inner join (
                select ROW_NUMBER () OVER (ORDER BY created_at desc) , *
                from new_profil_kampung
                where is_active is true
                order by created_at desc
            ) e on a.id = e.kampung_kb_id
            left join new_provinsi f on a.provinsi_id = f.id
            left join new_kabupaten g on a.kabupaten_id = g.id
            left join new_kecamatan h on a.kecamatan_id = h.id
            left join new_desa i on a.desa_id = i.id
            where a.is_active is not false
            order by b.jumlah_intervensi desc
            limit 10
        ";

        $key = md5(json_encode(request()->url()));
        $data = Cache::remember($key, 300, function () use ($sql) {
            return DB::select($sql);
        }) ;

        return $data;
    }


    public function profile($id)
    {
        if ($kampung = $this->kampungRepository->find($id)) {
            return redirect(
                route('portal.kampung.show', [
                    'kampung_id' => $kampung->id,
                    'slug' => Str::slug($kampung->nama),
                ]), 301
            );
        }

        abort(404);
    }

    public function subsite($id)
    {
        if ($kampung = $this->kampungRepository->find($id)) {
            return redirect(
                route('portal.kampung.intervensi.index', [
                    'kampung_id' => $kampung->id,
                ]), 301
            );
        }

        abort(404);
    }

    public function intervensi($kampung, $intervensi)
    {
        if ($intervensi = $this->intervensiRepository->find($intervensi)) {
            return redirect(
                route('portal.kampung.intervensi.show', [
                    'kampung_id' => $kampung,
                    'intervensi_id' => $intervensi->id,
                    'slug' => Str::slug($intervensi->judul),
                ]), 301
            );
        }

        abort(404);

    }


}
