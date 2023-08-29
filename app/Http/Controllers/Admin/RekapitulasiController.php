<?php

namespace App\Http\Controllers\Admin;

use Log;
use DB;
use Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Kampung,
    User,
};

use App\Repositories\Contract\{
    KampungRepository,
};
use App\DataTables\Admin\Rekapitulasi\{
    PengisiKontenDataTable,
    AdminKabupatenDataTable,
    AdminProvinsiDataTable,
    KlasifikasiDataTable,
    KampungDataTable
};


class RekapitulasiController extends Controller
{

    protected $repository;
    protected $dataTable;
    protected $pengisiKontenDataTable;
    protected $adminKabupatenDataTable;
    protected $adminProvinsiDataTable;
    protected $klasifikasiDataTable;

    public function __construct(
        KampungRepository $kampungRepository,
        PengisiKontenDataTable $pengisiKontenDataTable,
        AdminKabupatenDataTable $adminKabupatenDataTable,
        AdminProvinsiDataTable $adminProvinsiDataTable,
        KlasifikasiDataTable $klasifikasiDataTable,
        KampungDataTable $kampungDataTable
    ) {
        $this->repository = $kampungRepository;
        $this->pengisiKontenDataTable = $pengisiKontenDataTable;
        $this->adminKabupatenDataTable = $adminKabupatenDataTable;
        $this->adminProvinsiDataTable = $adminProvinsiDataTable;
        $this->klasifikasiDataTable = $klasifikasiDataTable;
        $this->kampungDataTable = $kampungDataTable;
        
    }

    public function pengisiKonten()
    {
        $this->dataTable = $this->pengisiKontenDataTable;
        return $this->dataTable->render('admin.rekapitulasi.index');
    }

    public function adminProvinsi()
    {
        $this->dataTable = $this->adminProvinsiDataTable;
        return $this->dataTable->render('admin.rekapitulasi.admin-wilayah', ['wilayah' => 'Provinsi']);
    }

    public function adminKabupaten()
    {
        $this->dataTable = $this->adminKabupatenDataTable;
        return $this->dataTable->render('admin.rekapitulasi.admin-wilayah', ['wilayah' => 'Kabupaten']);
    }

    public function klasifikasi()
    {
        $this->dataTable = $this->klasifikasiDataTable;
        return $this->dataTable->render('admin.rekapitulasi.klasifikasi');
    }

    public function kampung()
    {
        $this->dataTable = $this->kampungDataTable;
        return $this->dataTable->render('admin.rekapitulasi.kampung');
    }

}
