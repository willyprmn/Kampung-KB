<?php

namespace App\Http\Controllers\Portal;

use Cache;
use Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Portal\{
    Statistik\CapaianRoadmapDataTable,
    Statistik\CakupanWilayahDataTable,
    Statistik\TahunPembentukanDataTable,
    Statistik\KepemilikanSekretariatDataTable,
    Statistik\KepemilikanPokjaDataTable,
    Statistik\KepemilikanSkPokjaDataTable,
    Statistik\SumberDanaDataTable,
    Statistik\KepemilikanRegulasiDataTable,
    Statistik\KepemilikanPoktanDataTable,
    Statistik\PenggunaanDataDataTable,
    Statistik\KepemilikanRumahDatakuDataTable,
    Statistik\KepemilikanPlkbPendampingDataTable,
    Statistik\MekanismeOperasionalDataTable,
    Statistik\PokjaKampungKbTerlatihDataTable,
    Statistik\PokjaAnggotaTerlatihDataTable,
    Statistik\KepemilikanRkmDataTable,

    #intervensi
    Statistik\Intervensi\IntervensiLintasInstansiDataTable,
    Statistik\Intervensi\Inpres\DataAdministrasiDataTable,

    #fungsi keluarga
    Statistik\Intervensi\FungsiKeluarga\FungsiKeluargaDataTable,

    #inpres
    Statistik\Intervensi\Inpres\InpresDataAdministrasiDataTable,
    Statistik\Intervensi\Inpres\InpresGermasKomunikasiDataTable,
    Statistik\Intervensi\Inpres\InpresPkbmUkbmDataTable,
    Statistik\Intervensi\Inpres\InpresPendampinganPelayananDataTable,
    Statistik\Intervensi\Inpres\InpresPeningkatanCakupanDataTable,
    Statistik\Intervensi\Inpres\InpresPeningkatanCakupanLayananDataTable,
    Statistik\Intervensi\Inpres\InpresPemberdayaanEkonomiKeluargaDataTable,
    Statistik\Intervensi\Inpres\InpresPenataanLingkunganKeluargaDataTable,

    #kkbpk
    Statistik\Kkbpk\KkbpkJumlahPesertaPoktanDataTable,
    Statistik\Kkbpk\AngkaPartisipasiKegiatanPoktanDataTable,
    Statistik\Kkbpk\PesertaMixKontrasepsiDataTable,
    Statistik\Kkbpk\PusTidakPakaiKbDataTable,

    #classification
    Statistik\KlasifikasiDataTable,

};
use App\Repositories\Contract\{
    ConfigurationStatisticRepository
};

class ReportController extends Controller
{
    protected $capaianRoadmapDataTable,
        $cakupanWilayahDataTable,
        $tahunPembentukanDataTable,
        $kepemilikanSekretariatDataTable,
        $kepemilikanPokjaDataTable,
        $kepemilikanSkPokjaDataTable,
        $sumberDanaDataTable,
        $kepemilikanRegulasiDataTable,
        $kepemilikanPoktanDataTable,
        $penggunaanDataDataTable,
        $kepemilikanRumahDatakuDataTable,
        $kepemilikanPlkbPendampingDataTable,
        $mekanismeOperasionalDataTable,
        $intervensiLintasInstansiDataTable,
        $portalStatistikKkbpkJumlahPesertaPoktanDataTable,
        $pokjaKampungKbTerlatihDataTable,
        $pokjaAnggotaTerlatihDataTable,
        $portalStatistikKkbpkAngkaPartisipasiKegiatanPoktanDataTable,
        $portalStatistikKkbpkPesertaMixKontrasepsiDataTable,
        $portalStatistikPusTidakPakaiKbDataTable,
        $portalStatistikDataAdministrasiDataTable,

        $mergerData,

        $portalStatistikInpresDataAdministrasiDataTable,
        $portalStatistikInpresGermasKomunikasiDataTable,
        $portalStatistikInpresPkbmUkbmDataTable,
        $portalStatistikInpresPendampinganPelayananDataTable,
        $portalStatistikInpresPeningkatanCakupanDataTable,
        $portalStatistikInpresPeningkatanCakupanLayananDataTable,
        $portalStatistikInpresPemberdayaanEkonomiKeluargaDataTable,
        $portalStatistikInpresPenataanLingkunganKeluargaDataTable,
        $portalStatistikFungsiKeluargaDataTable,

        $portalStatistikKlasifikasiDataTable,
        $portalStatistikKepemilikanRkmDataTable;

    protected $configurationStatisticRepository;

    public function __construct(
        CapaianRoadmapDataTable $capaianRoadmapDataTable,
        CakupanWilayahDataTable $cakupanWilayahDataTable,
        TahunPembentukanDataTable $tahunPembentukanDataTable,
        KepemilikanSekretariatDataTable $kepemilikanSekretariatDataTable,
        KepemilikanPokjaDataTable $kepemilikanPokjaDataTable,
        KepemilikanSkPokjaDataTable $kepemilikanSkPokjaDataTable,
        SumberDanaDataTable $sumberDanaDataTable,
        KepemilikanRegulasiDataTable $kepemilikanRegulasiDataTable,
        KepemilikanPoktanDataTable $kepemilikanPoktanDataTable,
        PenggunaanDataDataTable $penggunaanDataDataTable,
        KepemilikanRumahDatakuDataTable $kepemilikanRumahDatakuDataTable,
        KepemilikanPlkbPendampingDataTable $kepemilikanPlkbPendampingDataTable,
        MekanismeOperasionalDataTable $mekanismeOperasionalDataTable,
        IntervensiLintasInstansiDataTable $intervensiLintasInstansiDataTable,
        KkbpkJumlahPesertaPoktanDataTable $kkbpkJumlahPesertaPoktanDataTable,
        PokjaKampungKbTerlatihDataTable $pokjaKampungKbTerlatihDataTable,
        PokjaAnggotaTerlatihDataTable $pokjaAnggotaTerlatihDataTable,
        AngkaPartisipasiKegiatanPoktanDataTable $angkaPartisipasiKegiatanPoktanDataTable,
        PesertaMixKontrasepsiDataTable $pesertaMixKontrasepsiDataTable,
        PusTidakPakaiKbDataTable $pusTidakPakaiKbDataTable,
        ConfigurationStatisticRepository $configurationStatisticRepository,

        InpresDataAdministrasiDataTable $dataAdministrasiDataTable,
        InpresGermasKomunikasiDataTable $germasKomunikasiDataTable,
        InpresPkbmUkbmDataTable $pkbmUkbmDataTable,
        InpresPendampinganPelayananDataTable $pendampinganPelayananDataTable,
        InpresPeningkatanCakupanDataTable $peningkatanCakupanDataTable,
        InpresPeningkatanCakupanLayananDataTable $peningkatanCakupanLayananDataTable,
        InpresPemberdayaanEkonomiKeluargaDataTable $pemberdayaanEkonomiKeluargaDataTable,
        InpresPenataanLingkunganKeluargaDataTable $penataanLingkunganKeluargaDataTable,
        FungsiKeluargaDataTable $fungsiKeluargaDataTable,
        KlasifikasiDataTable $classificationDataTable,
        KepemilikanRkmDataTable $kepemilikanRKMDataTable
    ) {

        $this->capaianRoadmapDataTable = $capaianRoadmapDataTable;
        $this->cakupanWilayahDataTable = $cakupanWilayahDataTable;
        $this->portalStatistikTahunPembentukanDataTable = $tahunPembentukanDataTable;
        $this->portalStatistikKepemilikanSekretariatDataTable = $kepemilikanSekretariatDataTable;
        $this->portalStatistikKepemilikanPokjaDataTable = $kepemilikanPokjaDataTable;
        $this->portalStatistikKepemilikanSkPokjaDataTable = $kepemilikanSkPokjaDataTable;
        $this->portalStatistikSumberDanaDataTable = $sumberDanaDataTable;
        $this->portalStatistikKepemilikanRegulasiDataTable = $kepemilikanRegulasiDataTable;
        $this->portalStatistikKepemilikanPoktanDataTable = $kepemilikanPoktanDataTable;
        $this->portalStatistikPenggunaanDataDataTable = $penggunaanDataDataTable;
        $this->portalStatistikKepemilikanRumahDatakuDataTable = $kepemilikanRumahDatakuDataTable;
        $this->portalStatistikKepemilikanPlkbPendampingDataTable = $kepemilikanPlkbPendampingDataTable;
        $this->portalStatistikMekanismeOperasionalDataTable = $mekanismeOperasionalDataTable;
        $this->portalStatistikIntervensiLintasInstansiDataTable = $intervensiLintasInstansiDataTable;
        $this->portalStatistikKkbpkJumlahPesertaPoktanDataTable = $kkbpkJumlahPesertaPoktanDataTable;
        $this->portalStatistikPokjaKampungKbTerlatihDataTable = $pokjaKampungKbTerlatihDataTable;
        $this->portalStatistikPokjaAnggotaTerlatihDataTable = $pokjaAnggotaTerlatihDataTable;
        $this->portalStatistikKkbpkAngkaPartisipasiKegiatanPoktanDataTable = $angkaPartisipasiKegiatanPoktanDataTable;
        $this->portalStatistikKkbpkPesertaMixKontrasepsiDataTable = $pesertaMixKontrasepsiDataTable;
        $this->portalStatistikPusTidakPakaiKbDataTable = $pusTidakPakaiKbDataTable;
        $this->configurationStatisticRepository = $configurationStatisticRepository;

        $this->portalStatistikInpresDataAdministrasiDataTable = $dataAdministrasiDataTable;
        $this->portalStatistikInpresGermasKomunikasiDataTable = $germasKomunikasiDataTable;
        $this->portalStatistikInpresPkbmUkbmDataTable = $pkbmUkbmDataTable;
        $this->portalStatistikInpresPendampinganPelayananDataTable = $pendampinganPelayananDataTable;
        $this->portalStatistikInpresPeningkatanCakupanDataTable = $peningkatanCakupanDataTable;
        $this->portalStatistikInpresPeningkatanCakupanLayananDataTable = $peningkatanCakupanLayananDataTable;
        $this->portalStatistikInpresPemberdayaanEkonomiKeluargaDataTable = $pemberdayaanEkonomiKeluargaDataTable;
        $this->portalStatistikInpresPenataanLingkunganKeluargaDataTable = $penataanLingkunganKeluargaDataTable;

        $this->portalStatistikFungsiKeluargaDataTable = $fungsiKeluargaDataTable;

        $this->portalStatistikKlasifikasiDataTable = $classificationDataTable;
        $this->portalStatistikKepemilikanRkmDataTable = $kepemilikanRKMDataTable;
    }

    public function index(Request $request)
    {

        $statistik = $this->configurationStatisticRepository
            ->where('route', '<>', null)
            ->firstOrFail()
            ;

        return redirect(
            route('portal.statistik.show', [
                'statistik' => $statistik->id,
                'slug' => Str::slug($statistik->title)
            ]), 301
        );

    }

    public function roadmap()
    {
        $name = "Capaian Terhadap Roadmap";
        $dataTable = $this->capaianRoadmapDataTable;

        return $dataTable->render('portal.page.statistic.include.show', compact('name'));
    }


    public function show($id)
    {

        $statistik = $this->configurationStatisticRepository->find($id);
        if (empty($statistik->parent_id) || empty($statistik->route)) return abort(404);

        $dataTableName = Str::camel(str_replace('.', ' ', $statistik->route)) . "DataTable";
        $dataTable = $this->$dataTableName;

        if(strpos($statistik->route, 'statistik.inpres-')){
            $statistics = $this->configurationStatisticRepository->whereIn('id', [24, 25, 26, 27, 28, 29, 30, 31])->get();
            return $dataTable->render('portal.page.statistic.include.inpres', compact('statistik', 'statistics'));

        }

        return $dataTable->render('portal.page.statistic.include.show', compact('statistik'));
    }
}
