<?php

use Illuminate\Database\Seeder;
use App\Models\{
    Kampung,
    Intervensi,
    ProfilKampung,
    ProfilProgram,
    PendudukKampung,
    Kkbpk,
    KampungDouble
};
use Illuminate\Support\Facades\DB;

class MergerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();
        #run merger double by nama desa yang sama
        $this->mergerDoubleByName();

        #run merger data dalam satu regional dan beda nama
        $this->mergerDoubleByRegion();
    }

    private function mergerDoubleByName(){
        #get kampung kb data double
        $dataDouble = DB::select(
            "select upper(regexp_replace(nama, '(\s+\d)|(\s+i+$)|(\s+NEW)', '', 'g')) nama,
                a.provinsi_id, c.name, a.kabupaten_id, d.name,
                a.kecamatan_id, e.name, a.desa_id, f.name
            from new_kampung_kb a
            inner join (
                select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                from new_kampung_kb
                --where id in ('6979', '37538')
                group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                having count(1) > 1
            ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
            and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
            left join new_provinsi c on a.provinsi_id = c.id
            left join new_kabupaten d on a.kabupaten_id = d.id
            left join new_kecamatan e on a.kecamatan_id = e.id
            left join new_desa f on a.desa_id = f.id
            where a.is_active is not false
            group by upper(regexp_replace(nama, '(\s+\d)|(\s+i+$)|(\s+NEW)', '', 'g')),
                a.provinsi_id, c.name, a.kabupaten_id, d.name,
                a.kecamatan_id, e.name, a.desa_id, f.name
            having count(1) > 1

            "
        );

        #cari jumlah intervensi yang paling banyak
        #jika jumlah intervensi sama, maka ambil jumlah profil terbanyak
        #jika jumlah profil sama, maka ambil jumlah penduduk terbanyak
        #jika jumlah penduduk sama maka ambil jumlah kkbpk terbanyak
        #jika jumlah kkbpk sama maka ambil  max id kampung kb

        foreach($dataDouble as $key => $item){
            // $nama = 'NGUDI MULYA';
            // $provinsi = '33';
            // $kabupaten = '3311';
            // $kecamatan = '331102';
            // $desa = '3311022007';

            $nama = $item->nama;
            $provinsi = $item->provinsi_id;
            $kabupaten = $item->kabupaten_id;
            $kecamatan = $item->kecamatan_id;
            $desa = $item->desa_id;

            #get max jumlah relasi
            $sql = "select min(jumlah_intervensi) min_intervensi,
                    max(jumlah_intervensi) max_intervensi,
                    min(jumlah_profil) min_profil,
                    max(jumlah_profil) max_profil,
                    min(jumlah_penduduk) min_penduduk,
                    max(jumlah_penduduk) max_penduduk,
                    min(jumlah_kkbpk) min_kkbpk,
                    max(jumlah_kkbpk) max_kkbpk
                from (

                    select a.id, a.nama, a.tanggal_pencanangan, a.cakupan_wilayah,
                        a.provinsi_id, c.name provinsi, a.kabupaten_id, d.name kabupaten,
                        a.kecamatan_id, e.name kecamatan, a.desa_id, f.name desa,
                        (select count(1) from new_intervensi x where x.kampung_kb_id = a.id) jumlah_intervensi,
                        (select count(1) from new_profil_kampung x where x.kampung_kb_id = a.id) jumlah_profil,
                        (select count(1) from new_penduduk_kampung x where x.kampung_kb_id = a.id) jumlah_penduduk,
                        (select count(1) from new_kkbpk_kampung x where x.kampung_kb_id = a.id) jumlah_kkbpk,
                        total total_kampung
                    from new_kampung_kb a
                    inner join (
                        select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                        from new_kampung_kb
                        --where is_active is not false
                        group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                        having count(1) > 1
                    ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
                    and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
                    left join new_provinsi c on a.provinsi_id = c.id
                    left join new_kabupaten d on a.kabupaten_id = d.id
                    left join new_kecamatan e on a.kecamatan_id = e.id
                    left join new_desa f on a.desa_id = f.id
                    where upper(regexp_replace(nama, '(\s+\d)|(\s+i+$)|(\s+NEW)', '', 'g')) ilike '%{$nama}%'
                    and a.provinsi_id = '{$provinsi}'
                    and a.kabupaten_id = '{$kabupaten}'
                    and a.kecamatan_id = '{$kecamatan}'
                    and a.desa_id = '{$desa}'
                    and a.is_active is not false
                ) a

            ";
            $dataCount = DB::select($sql);

            #compare min and max data
            $min_intervensi = $dataCount[0]->min_intervensi;
            $max_intervensi = $dataCount[0]->max_intervensi;

            $min_profil = $dataCount[0]->min_profil;
            $max_profil = $dataCount[0]->max_profil;

            $min_penduduk = $dataCount[0]->min_penduduk;
            $max_penduduk = $dataCount[0]->max_penduduk;

            $min_kkbpk = $dataCount[0]->min_kkbpk;
            $max_kkbpk = $dataCount[0]->max_kkbpk;

            $masterMerger = array();
            #jika ada jumlah max intervensi maka langsung ambil max intervensi
            if($max_intervensi > $min_intervensi){

                $masterMerger = [
                    'type' => 'jumlah_intervensi',
                    'value' => $max_intervensi
                ];

            }

            #jika jumlah max intervensi sama, maka cari jumlah max profil
            if($max_intervensi === $min_intervensi){

                if($max_profil > $min_profil){

                    $masterMerger = [
                        'type' => 'jumlah_profil',
                        'value' => $max_profil
                    ];

                }

                #jika jumlah max profil sama, maka cari jumlah max penduduk
                if($max_profil === $min_profil){

                    if($max_penduduk > $min_penduduk){

                        $masterMerger = [
                            'type' => 'jumlah_penduduk',
                            'value' => $max_penduduk
                        ];

                    }

                    #jika jumlah max penduduk sama, maka cari jumlah max kkbpk
                    if($max_penduduk === $min_penduduk){

                        if($max_kkbpk > $min_kkbpk){

                            $masterMerger = [
                                'type' => 'jumlah_kkbpk',
                                'value' => $max_kkbpk
                            ];

                        }

                        #jika semuanya sama nilainya, maka ambil salah satu id max kampung kb
                        if($max_kkbpk === $min_kkbpk){

                            $masterMerger = [
                                'type' => 'max_kampung',
                                'value' => '0'
                            ];

                        }

                    }

                }

            }

            if($masterMerger['type'] === 'max_kampung'){
                $masterMergerKampung = DB::select(
                    "select max(id) id
                    from (

                        select a.id, a.nama, a.tanggal_pencanangan, a.cakupan_wilayah,
                            a.provinsi_id, c.name provinsi, a.kabupaten_id, d.name kabupaten,
                            a.kecamatan_id, e.name kecamatan, a.desa_id, f.name desa,
                            (select count(1) from new_intervensi x where x.kampung_kb_id = a.id) jumlah_intervensi,
                            (select count(1) from new_profil_kampung x where x.kampung_kb_id = a.id) jumlah_profil,
                            (select count(1) from new_penduduk_kampung x where x.kampung_kb_id = a.id) jumlah_penduduk,
                            (select count(1) from new_kkbpk_kampung x where x.kampung_kb_id = a.id) jumlah_kkbpk,
                            total total_kampung
                        from new_kampung_kb a
                        inner join (
                            select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                            from new_kampung_kb
                            group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                            having count(1) > 1
                        ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
                        and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
                        left join new_provinsi c on a.provinsi_id = c.id
                        left join new_kabupaten d on a.kabupaten_id = d.id
                        left join new_kecamatan e on a.kecamatan_id = e.id
                        left join new_desa f on a.desa_id = f.id
                        where upper(regexp_replace(nama, '(\s+\d)|(\s+i+$)|(\s+NEW)', '', 'g')) ilike '%{$nama}%'
                        and a.provinsi_id = '{$provinsi}'
                        and a.kabupaten_id = '{$kabupaten}'
                        and a.kecamatan_id = '{$kecamatan}'
                        and a.desa_id = '{$desa}'
                        -- and a.is_active is not false
                    ) a
                    "
                );
            }
            else{

                $masterMergerKampung = DB::select(
                    "select *
                    from (

                        select a.id, a.nama, a.tanggal_pencanangan, a.cakupan_wilayah,
                            a.provinsi_id, c.name provinsi, a.kabupaten_id, d.name kabupaten,
                            a.kecamatan_id, e.name kecamatan, a.desa_id, f.name desa,
                            (select count(1) from new_intervensi x where x.kampung_kb_id = a.id) jumlah_intervensi,
                            (select count(1) from new_profil_kampung x where x.kampung_kb_id = a.id) jumlah_profil,
                            (select count(1) from new_penduduk_kampung x where x.kampung_kb_id = a.id) jumlah_penduduk,
                            (select count(1) from new_kkbpk_kampung x where x.kampung_kb_id = a.id) jumlah_kkbpk,
                            total total_kampung
                        from new_kampung_kb a
                        inner join (
                            select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                            from new_kampung_kb
                            group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                            having count(1) > 1
                        ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
                        and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
                        left join new_provinsi c on a.provinsi_id = c.id
                        left join new_kabupaten d on a.kabupaten_id = d.id
                        left join new_kecamatan e on a.kecamatan_id = e.id
                        left join new_desa f on a.desa_id = f.id
                        where upper(regexp_replace(nama, '(\s+\d)|(\s+i+$)|(\s+NEW)', '', 'g')) ilike '%{$nama}%'
                        and a.provinsi_id = '{$provinsi}'
                        and a.kabupaten_id = '{$kabupaten}'
                        and a.kecamatan_id = '{$kecamatan}'
                        and a.desa_id = '{$desa}'
                        --and a.is_active is not false
                    ) a
                    where {$masterMerger['type']} = {$masterMerger['value']}
                    "
                );
            }

            $masterId = $masterMergerKampung[0]->id;
            //get master kampung acuan
            $kampungMaster = Kampung::where('id', [$masterId])
                ->with(['intervensis', 'profil', 'penduduk', 'kkbpk', 'penduduks', 'profils'])
                ->first();
            #update kampung id pada data semua yang double menggunakan id master merger kampung
            #get data yang double tanpa select id kampung yang akan jadi master merger
            $doubles = Kampung::where([
                    ['provinsi_id', '=',  $provinsi],
                    ['kabupaten_id', '=',  $kabupaten],
                    ['kecamatan_id', '=',  $kecamatan],
                    ['desa_id', '=',  $desa],
                ])
                ->where('nama', 'ILIKE', "%$nama%")
                ->where('id', '<>', $masterId)
                ->with([
                    'intervensis' => function($query){
                        return $query->with([
                            'sasarans',
                            'instansis'
                        ]);
                    },
                    'profil' => function($profil){
                        return $profil->with([
                            'programs' => function($program){
                                return $program->withPivot('program_flag');
                            },
                            'operasionals',
                            'sumber_danas',
                        ]);
                    },
                    'profils',
                    'penduduks',
                    'penduduk' => function($query){
                        return $query->with([
                            'ranges' => function($query){
                                return $query->withPivot('jumlah', 'jenis_kelamin');
                            },
                            'keluargas',
                            'penduduk_ranges'
                        ]);
                    },
                    'kkbpk' => function($query){
                        return $query->with([
                            'programs' => function($query){
                                return $query->withPivot('jumlah');
                            },
                            'kontrasepsis' => function($query){
                                return $query->withPivot('jumlah');
                            },
                            'non_kontrasepsis' => function($query){
                                return $query->withPivot('jumlah');
                            },
                        ]);
                    },
                    ]
                )
                ->get();

            foreach($doubles as $key =>  $double){
                echo $double->id;
                echo '<br>';
                DB::beginTransaction();

                try{

                    if(sizeof($double->intervensis) > 0){
                        #do insert data intervensi
                        $intervensis = $double->intervensis->map(function($item) use($masterId) {
                            $intervensi = array(
                                "kampung_kb_id" => $masterId,
                                "jenis_post_id" => $item->jenis_post_id,
                                "judul" => $item->judul,
                                "tanggal" => $item->tanggal,
                                "tempat" => $item->tempat,
                                "deskripsi" => $item->deskripsi,
                                "kategori_id" => $item->kategori_id,
                                "program_id" => $item->program_id,
                            );
                            $intervensi = Intervensi::create($intervensi);

                            // sasarans,
                            if(!empty($item->sasarans)){
                                $data = $item->sasarans->mapWithKeys(function($query) use($intervensi){
                                    $arar = $query->toArray();
                                    return [
                                        $query->id => [
                                            "intervensi_id" => $intervensi->id,
                                            "sasaran_id" => $query->pivot->sasaran_id,
                                            "sasaran_lainnya" => $query->pivot->sasaran_lainnya,
                                        ]
                                    ];
                                });

                                $intervensi->sasarans()->attach($data);
                            }

                            // instansis,
                            if(!empty($item->instansis)){
                                $data = $item->instansis->mapWithKeys(function($query) use($intervensi){
                                    $arar = $query->toArray();
                                    return [
                                        $query->id => [
                                            "intervensi_id" => $intervensi->id,
                                            "instansi_id" => $query->pivot->instansi_id,
                                            "instansi_lainnya" => $query->pivot->instansi_lainnya,
                                        ]
                                    ];
                                });

                                $intervensi->instansis()->attach($data);
                            }

                        });

                    }

                    #compare created at double dengan created at master
                    #jika yg double lebih terbaru maka insert data tersebut ke master

                    #profil
                    if(!empty($double->profil) && !empty($kampungMaster->profil)){

                        if($double->profil->created_at > $kampungMaster->profil->created_at){

                            if(sizeof($double->profils->toArray()) > 1 && sizeof($kampungMaster->profils->toArray()) > 1)
                            {
                                //update status false untuk profil master
                                $profilMaster = ProfilKampung::find($kampungMaster->profil->id);
                                $profilMaster->is_active = null;
                                $profilMaster->save();

                                #insert latest update dari data double ke master
                                $profilInsert = $double->profil->toArray();
                                $profilInsert['kampung_kb_id'] = $masterId;
                                $profil = ProfilKampung::create($profilInsert);

                                #insert relation profil
                                // 'profil_programs',
                                if(!empty($double->profil->programs)){
                                    $programs = $double->profil->programs->mapWithKeys(function($program) use($profil){
                                        return [
                                            $program->id => [
                                                "profil_id" => $profil->id,
                                                "program_flag" => $program->pivot->program_flag,
                                            ]
                                        ];
                                    });

                                    $profil->programs()->attach($programs);

                                }

                                // 'profil_operasionals',
                                if(!empty($double->profil->operasionals)){
                                    $operasionals = $double->profil->operasionals->mapWithKeys(function($query) use($profil){
                                        $arar = $query->toArray();
                                        return [
                                            $query->id => [
                                                "profil_id" => $profil->id,
                                                "operasional_id" => $query->pivot->operasional_id,
                                                "operasional_flag" => $query->pivot->operasional_flag,
                                                "frekuensi_id" => $query->pivot->frekuensi_id,
                                                "frekuensi_lainnya" => $query->pivot->frekuensi_lainnya,
                                            ]
                                        ];
                                    });

                                    $profil->operasionals()->attach($operasionals);

                                }

                                // 'profil_sumber_danas',
                                if(!empty($double->profil->sumber_danas)){
                                    $data = $double->profil->sumber_danas->mapWithKeys(function($query) use($profil){
                                        $arar = $query->toArray();
                                        return [
                                            $query->id => [
                                                "profil_id" => $profil->id,
                                                "sumber_dana_id" => $query->pivot->sumber_dana_id,
                                            ]
                                        ];
                                    });

                                    $profil->sumber_danas()->attach($data);

                                }

                                // 'profil_penggunaan_datas',
                                if($double->profil->penggunaan_data_flag === true && !empty($double->profil->penggunaan_datas)){
                                    $data = $double->profil->penggunaan_datas->mapWithKeys(function($query) use($profil){
                                        $arar = $query->toArray();
                                        return [
                                            $query->id => [
                                                "profil_id" => $profil->id,
                                                "penggunaan_data_id" => $query->pivot->penggunaan_data_id,
                                            ]
                                        ];
                                    });

                                    $profil->penggunaan_datas()->attach($data);

                                }
                            }
                        }

                    }

                    #penduduk
                    if(!empty($double->penduduk) && !empty($kampungMaster->penduduk)) {

                        if($double->penduduk->created_at > $kampungMaster->penduduk->created_at){

                            if(sizeof($double->penduduks->toArray()) > 1 && sizeof($kampungMaster->penduduks->toArray()) > 1)
                            {
                                //update status false untuk penduduk master
                                $pendudukMaster = PendudukKampung::find($kampungMaster->penduduk->id);
                                $pendudukMaster->is_active = null;
                                $pendudukMaster->save();

                                #insert latest update dari data double ke master
                                $pendudukInsert = $double->penduduk->toArray();
                                $pendudukInsert['kampung_kb_id'] = $masterId;
                                $penduduk = PendudukKampung::create($pendudukInsert);

                                #insert relation penduduk
                                // ranges,
                                if(!empty($double->penduduk->ranges)){
                                    $data = $double->penduduk->penduduk_ranges->map(function($query) use($penduduk){
                                        $ar = $query->toArray();
                                        return [
                                            "penduduk_kampung_id" => $penduduk->id,
                                            "range_id" => $query->range_id,
                                            "jumlah" => $query->jumlah,
                                            "jenis_kelamin" => $query->jenis_kelamin,
                                        ];
                                    });
                                    $penduduk->penduduk_ranges()->createMany($data);
                                }

                                // keluargas,
                                if(!empty($double->penduduk->keluargas)){
                                    $data = $double->penduduk->keluargas->mapWithKeys(function($query) use($penduduk){
                                        return [
                                            $query->id => [
                                                "penduduk_kampung_id" => $penduduk->id,
                                                "keluarga_id" => $query->pivot->keluarga_id,
                                                "jumlah" => $query->pivot->jumlah,
                                            ]
                                        ];
                                    });

                                    $penduduk->keluargas()->attach($data);

                                }
                            }

                        }

                    }

                    // #kkbpk
                    if((!empty($double->kkbpk) && empty($kampungMaster->kkbpk) ) || (!empty($double->kkbpk) && !empty($kampungMaster->kkbpk))){

                        if((empty($kampungMaster->kkbpk) && !empty($double->kkbpk->created_at)) ||
                            ($double->kkbpk->created_at > $kampungMaster->kkbpk->created_at)){

                            //update status false untuk kkbpk master
                            if(isset($kampungMaster->kkbpk)){
                                $kkbpkMaster = Kkbpk::find($kampungMaster->kkbpk->id);
                                $kkbpkMaster->is_active = null;
                                $kkbpkMaster->save();
                            }

                            #insert latest update dari data double ke master
                            $kkbpkInsert = $double->kkbpk->toArray();
                            $kkbpkInsert['kampung_kb_id'] = $masterId;
                            $kkbpk = Kkbpk::create($kkbpkInsert);

                            #insert table relations
                            // programs,
                            if(!empty($double->kkbpk->programs)){
                                $data = $double->kkbpk->programs->mapWithKeys(function($query) use($kkbpk){
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kkbpk->id,
                                            "program_id" => $query->pivot->program_id,
                                            "jumlah" => $query->pivot->jumlah,
                                        ]
                                    ];
                                });

                                $kkbpk->programs()->attach($data);
                            }

                            // kontrasepsis,
                            if(!empty($double->kkbpk->kontrasepsis)){
                                $data = $double->kkbpk->kontrasepsis->mapWithKeys(function($query) use($kkbpk){
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kkbpk->id,
                                            "kontrasepsi_id" => $query->pivot->kontrasepsi_id,
                                            "jumlah" => $query->pivot->jumlah,
                                        ]
                                    ];
                                });

                                $kkbpk->kontrasepsis()->attach($data);
                            }

                            // non kontrasepsis,
                            if(!empty($double->kkbpk->non_kontrasepsis)){
                                $data = $double->kkbpk->non_kontrasepsis->mapWithKeys(function($query) use($kkbpk){
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kkbpk->id,
                                            "non_kontrasepsi_id" => $query->pivot->non_kontrasepsi_id,
                                            "jumlah" => $query->pivot->jumlah,
                                        ]
                                    ];
                                });

                                $kkbpk->non_kontrasepsis()->attach($data);
                            }

                        }

                    }

                    #update flag double
                    $kampung = Kampung::find($double->id);
                    $kampung->is_active = false;
                    $kampung->save();
                    // dd($kampung->toArray());

                    //insert rekap id kampung double
                    $double = array(
                        'kampung_id' => $masterId,
                        'kampung_id_double' => $double->id,
                        'merger_proses' => 'Merger Double By Name',
                        'merger_kriteria' => $masterMerger['type']
                    );
                    KampungDouble::insert($double);

                    #update flag master
                    // $kampung = Kampung::find($masterId);
                    // $kampung->is_active = true;
                    // $kampung->save();

                    DB::commit();

                }catch(Throwable $e){

                    DB::rollback();

                }


            }

        // }

            // dd($doubles->toArray());
        }

    }

    private function mergerDoubleByRegion(){
        #get kampung kb data double
        $dataDouble = DB::select(
            "
            select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
            from new_kampung_kb
            where is_active is not false and desa_id is not null
            --and id in ('20477', '1346')
            group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
            having count(1) > 1
            "
        );

        #cari jumlah intervensi yang paling banyak
        #jika jumlah intervensi sama, maka ambil jumlah profil terbanyak
        #jika jumlah profil sama, maka ambil jumlah penduduk terbanyak
        #jika jumlah penduduk sama maka ambil jumlah kkbpk terbanyak
        #jika jumlah kkbpk sama maka ambil  max id kampung kb

        foreach($dataDouble as $key => $item){
            // $nama = 'DESA CANDIKUSUMA';
            // $provinsi = '51';
            // $kabupaten = '5101';
            // $kecamatan = '510104';
            // $desa = '5101042007';

            $provinsi = $item->provinsi_id;
            $kabupaten = $item->kabupaten_id;
            $kecamatan = $item->kecamatan_id;
            $desa = $item->desa_id;

            #get max jumlah relasi
            $dataCount = DB::select(
                "select min(jumlah_intervensi) min_intervensi,
                    max(jumlah_intervensi) max_intervensi,
                    min(jumlah_profil) min_profil,
                    max(jumlah_profil) max_profil,
                    min(jumlah_penduduk) min_penduduk,
                    max(jumlah_penduduk) max_penduduk,
                    min(jumlah_kkbpk) min_kkbpk,
                    max(jumlah_kkbpk) max_kkbpk
                from (
                    select a.id, a.nama, a.tanggal_pencanangan, a.cakupan_wilayah,
                        a.provinsi_id, c.name provinsi, a.kabupaten_id, d.name kabupaten,
                        a.kecamatan_id, e.name kecamatan, a.desa_id, f.name desa,
                        (select count(1) from new_intervensi x where x.kampung_kb_id = a.id) jumlah_intervensi,
                        (select count(1) from new_profil_kampung x where x.kampung_kb_id = a.id) jumlah_profil,
                        (select count(1) from new_penduduk_kampung x where x.kampung_kb_id = a.id) jumlah_penduduk,
                        (select count(1) from new_kkbpk_kampung x where x.kampung_kb_id = a.id) jumlah_kkbpk,
                        total total_kampung
                    from new_kampung_kb a
                    inner join (
                        select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                        from new_kampung_kb
                        where is_active is not false and desa_id is not null
                        group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                        having count(1) > 1
                    ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
                    and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
                    left join new_provinsi c on a.provinsi_id = c.id
                    left join new_kabupaten d on a.kabupaten_id = d.id
                    left join new_kecamatan e on a.kecamatan_id = e.id
                    left join new_desa f on a.desa_id = f.id
                    where a.provinsi_id = '{$provinsi}'
                    and a.kabupaten_id = '{$kabupaten}'
                    and a.kecamatan_id = '{$kecamatan}'
                    and a.desa_id = '{$desa}'
                    and a.is_active is not false and a.desa_id is not null
                ) a
                "
            );

            #compare min and max data
            $min_intervensi = $dataCount[0]->min_intervensi;
            $max_intervensi = $dataCount[0]->max_intervensi;

            $min_profil = $dataCount[0]->min_profil;
            $max_profil = $dataCount[0]->max_profil;

            $min_penduduk = $dataCount[0]->min_penduduk;
            $max_penduduk = $dataCount[0]->max_penduduk;

            $min_kkbpk = $dataCount[0]->min_kkbpk;
            $max_kkbpk = $dataCount[0]->max_kkbpk;

            $masterMerger = array();
            #jika ada jumlah max intervensi maka langsung ambil max intervensi
            if($max_intervensi > $min_intervensi){

                $masterMerger = [
                    'type' => 'jumlah_intervensi',
                    'value' => $max_intervensi
                ];

            }

            #jika jumlah max intervensi sama, maka cari jumlah max profil
            if($max_intervensi === $min_intervensi){

                if($max_profil > $min_profil){

                    $masterMerger = [
                        'type' => 'jumlah_profil',
                        'value' => $max_profil
                    ];

                }

                #jika jumlah max profil sama, maka cari jumlah max penduduk
                if($max_profil === $min_profil){

                    if($max_penduduk > $min_penduduk){

                        $masterMerger = [
                            'type' => 'jumlah_penduduk',
                            'value' => $max_penduduk
                        ];

                    }

                    #jika jumlah max penduduk sama, maka cari jumlah max kkbpk
                    if($max_penduduk === $min_penduduk){

                        if($max_kkbpk > $min_kkbpk){

                            $masterMerger = [
                                'type' => 'jumlah_kkbpk',
                                'value' => $max_kkbpk
                            ];

                        }

                        #jika semuanya sama nilainya, maka ambil salah satu id max kampung kb
                        if($max_kkbpk === $min_kkbpk){

                            $masterMerger = [
                                'type' => 'max_kampung',
                                'value' => '0'
                            ];

                        }

                    }

                }

            }

            if($masterMerger['type'] === 'max_kampung'){
                $sql = "select max(id) id
                    from (

                        select a.id, a.nama, a.tanggal_pencanangan, a.cakupan_wilayah,
                            a.provinsi_id, c.name provinsi, a.kabupaten_id, d.name kabupaten,
                            a.kecamatan_id, e.name kecamatan, a.desa_id, f.name desa,
                            (select count(1) from new_intervensi x where x.kampung_kb_id = a.id) jumlah_intervensi,
                            (select count(1) from new_profil_kampung x where x.kampung_kb_id = a.id) jumlah_profil,
                            (select count(1) from new_penduduk_kampung x where x.kampung_kb_id = a.id) jumlah_penduduk,
                            (select count(1) from new_kkbpk_kampung x where x.kampung_kb_id = a.id) jumlah_kkbpk,
                            total total_kampung
                        from new_kampung_kb a
                        inner join (
                            select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                            from new_kampung_kb
                            where is_active is not false and desa_id is not null
                            group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                            having count(1) > 1
                        ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
                        and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
                        left join new_provinsi c on a.provinsi_id = c.id
                        left join new_kabupaten d on a.kabupaten_id = d.id
                        left join new_kecamatan e on a.kecamatan_id = e.id
                        left join new_desa f on a.desa_id = f.id
                        where a.provinsi_id = '{$provinsi}'
                        and a.kabupaten_id = '{$kabupaten}'
                        and a.kecamatan_id = '{$kecamatan}'
                        and a.desa_id = '{$desa}'
                        and a.is_active is not false and a.desa_id is not null
                    ) a
                    "
                ;

                $masterMergerKampung = DB::select($sql);

            }
            else{
                $masterMergerKampung = DB::select(
                    "select *
                    from (

                        select a.id, a.nama, a.tanggal_pencanangan, a.cakupan_wilayah,
                            a.provinsi_id, c.name provinsi, a.kabupaten_id, d.name kabupaten,
                            a.kecamatan_id, e.name kecamatan, a.desa_id, f.name desa,
                            (select count(1) from new_intervensi x where x.kampung_kb_id = a.id) jumlah_intervensi,
                            (select count(1) from new_profil_kampung x where x.kampung_kb_id = a.id) jumlah_profil,
                            (select count(1) from new_penduduk_kampung x where x.kampung_kb_id = a.id) jumlah_penduduk,
                            (select count(1) from new_kkbpk_kampung x where x.kampung_kb_id = a.id) jumlah_kkbpk,
                            total total_kampung
                        from new_kampung_kb a
                        inner join (
                            select provinsi_id, kabupaten_id, kecamatan_id, desa_id, count(1) total
                            from new_kampung_kb
                            --where is_active is not false and desa_id is not null
                            group by provinsi_id, kabupaten_id, kecamatan_id, desa_id
                            having count(1) > 1
                        ) b on a.provinsi_id = b.provinsi_id and a.kabupaten_id = b.kabupaten_id
                        and a.kecamatan_id = b.kecamatan_id and a.desa_id = b.desa_id
                        left join new_provinsi c on a.provinsi_id = c.id
                        left join new_kabupaten d on a.kabupaten_id = d.id
                        left join new_kecamatan e on a.kecamatan_id = e.id
                        left join new_desa f on a.desa_id = f.id
                        where a.provinsi_id = '{$provinsi}'
                        and a.kabupaten_id = '{$kabupaten}'
                        and a.kecamatan_id = '{$kecamatan}'
                        and a.desa_id = '{$desa}'
                        and a.is_active is not false and a.desa_id is not null
                    ) a
                    where {$masterMerger['type']} = {$masterMerger['value']}
                    "
                );
            }

            $masterId = $masterMergerKampung[0]->id;
            //get master kampung acuan
            $kampungMaster = Kampung::where('id', [$masterId])
                ->with(['intervensis', 'profil', 'penduduk', 'kkbpk', 'profils', 'penduduks'])
                ->first();

            #update kampung id pada data semua yang double menggunakan id master merger kampung
            #get data yang double tanpa select id kampung yang akan jadi master merger
            $doubles = Kampung::where([
                    ['provinsi_id', '=',  $provinsi],
                    ['kabupaten_id', '=',  $kabupaten],
                    ['kecamatan_id', '=',  $kecamatan],
                    ['desa_id', '=',  $desa],
                ])
                ->where('id', '<>', $masterId)
                ->where('is_active', '=', null)
                ->where('desa_id', '!=', null)
                ->with([
                    'intervensis' => function($query){
                        return $query->with([
                            'sasarans',
                            'instansis'
                        ]);
                    },
                    'profil' => function($profil){
                        return $profil->with([
                            'programs' => function($program){
                                return $program->withPivot('program_flag');
                            },
                            'operasionals',
                            'sumber_danas',
                        ]);
                    },
                    'penduduk' => function($query){
                        return $query->with([
                            'ranges' => function($query){
                                return $query->withPivot('jumlah', 'jenis_kelamin');
                            },
                            'keluargas',
                            'penduduk_ranges'
                        ]);
                    },
                    'kkbpk' => function($query){
                        return $query->with([
                            'programs' => function($query){
                                return $query->withPivot('jumlah');
                            },
                            'kontrasepsis' => function($query){
                                return $query->withPivot('jumlah');
                            },
                            'non_kontrasepsis' => function($query){
                                return $query->withPivot('jumlah');
                            },
                        ]);
                    },
                    'profils', 'penduduks'
                    ]
                )
                ->get();

            $x = $doubles->toArray();

            foreach($doubles as $key =>  $double){
                echo $double->id;
                echo '<br>';
                DB::beginTransaction();

                try{

                    #intervensi
                    if(sizeof($double->intervensis) > 0){

                        #do insert data intervensi
                        $intervensis = $double->intervensis->map(function($item) use($masterId) {
                            $intervensi = array(
                                "kampung_kb_id" => $masterId,
                                "jenis_post_id" => $item->jenis_post_id,
                                "judul" => $item->judul,
                                "tanggal" => $item->tanggal,
                                "tempat" => $item->tempat,
                                "deskripsi" => $item->deskripsi,
                                "kategori_id" => $item->kategori_id,
                                "program_id" => $item->program_id,
                            );
                            $intervensi = Intervensi::create($intervensi);

                            // sasarans,
                            if(!empty($item->sasarans)){

                                $data = $item->sasarans->mapWithKeys(function($query) use($intervensi){
                                    $arar = $query->toArray();
                                    return [
                                        $query->id => [
                                            "intervensi_id" => $intervensi->id,
                                            "sasaran_id" => $query->pivot->sasaran_id,
                                            "sasaran_lainnya" => $query->pivot->sasaran_lainnya,
                                        ]
                                    ];
                                });

                                $intervensi->sasarans()->attach($data);
                            }

                            // instansis,
                            if(!empty($item->instansis)){
                                $data = $item->instansis->mapWithKeys(function($query) use($intervensi){
                                    $arar = $query->toArray();
                                    return [
                                        $query->id => [
                                            "intervensi_id" => $intervensi->id,
                                            "instansi_id" => $query->pivot->instansi_id,
                                            "instansi_lainnya" => $query->pivot->instansi_lainnya,
                                        ]
                                    ];
                                });

                                $intervensi->instansis()->attach($data);
                            }

                        });

                    }

                    // #compare created at double dengan created at master
                    // #jika yg double lebih terbaru maka insert data tersebut ke master

                    // #profil
                    if(!empty($double->profil) && !empty($kampungMaster->profil)){

                        if($double->profil->created_at > $kampungMaster->profil->created_at){

                            if(sizeof($double->profils->toArray()) > 1 && sizeof($kampungMaster->profils->toArray()) > 1)
                            {
                                //compare value
                                // $profilMaster = ProfilKampung::find($kampungMaster->profil->id);
                                if(($kampungMaster->profil->pokja_pengurusan_flag === false || $kampungMaster->profil->pokja_pengurusan_flag === null)
                                    && $double->profil->pokja_pengurusan_flag === true)
                                {
                                    $kampungMaster->profil->pokja_pengurusan_flag = $double->profil->pokja_pengurusan_flag;
                                }

                                if(($kampungMaster->profil->pokja_sk_flag === false || $kampungMaster->profil->pokja_sk_flag === null)
                                    && $double->profil->pokja_sk_flag === true)
                                {
                                    $kampungMaster->profil->pokja_sk_flag = $double->profil->pokja_sk_flag;
                                }

                                if(($kampungMaster->profil->pokja_pelatihan_flag === false || $kampungMaster->profil->pokja_pelatihan_flag === null)
                                    && $double->profil->pokja_pelatihan_flag === true)
                                {
                                    $kampungMaster->profil->pokja_pelatihan_flag = $double->profil->pokja_pelatihan_flag;
                                    $kampungMaster->profil->pokja_pelatihan_desc = $double->profil->pokja_pelatihan_desc;
                                    $kampungMaster->profil->pokja_jumlah = $double->profil->pokja_jumlah;
                                    $kampungMaster->profil->pokja_jumlah_terlatih = $double->profil->pokja_jumlah_terlatih;
                                }

                                if(($kampungMaster->profil->plkb_pendamping_flag === false || $kampungMaster->profil->plkb_pendamping_flag === null)
                                    && $double->profil->plkb_pendamping_flag === true)
                                {
                                    $kampungMaster->profil->plkb_pendamping_flag = $double->profil->plkb_pendamping_flag;
                                    $kampungMaster->profil->plkb_nip = $double->profil->plkb_nip;
                                    $kampungMaster->profil->plkb_nama = $double->profil->plkb_nama;
                                    $kampungMaster->profil->plkb_kontak = $double->profil->plkb_kontak;
                                    $kampungMaster->profil->plkb_pengarah_id = $double->profil->plkb_pengarah_id;
                                    $kampungMaster->profil->plkb_pengarah_lainnya = $double->profil->plkb_pengarah_lainnya;
                                }

                                if(($kampungMaster->profil->regulasi_flag === false || $kampungMaster->profil->regulasi_flag === null)
                                    && $double->profil->regulasi_flag === true)
                                {
                                    $kampungMaster->profil->regulasi_flag = $double->profil->regulasi_flag;
                                    $kampungMaster->profil->regulasi_id = $double->profil->regulasi_id;
                                }

                                if(($kampungMaster->profil->rencana_kerja_masyarakat_flag === false || $kampungMaster->profil->rencana_kerja_masyarakat_flag === null)
                                    && $double->profil->rencana_kerja_masyarakat_flag === true)
                                {
                                    $kampungMaster->profil->rencana_kerja_masyarakat_flag = $double->profil->rencana_kerja_masyarakat_flag;
                                    $kampungMaster->profil->penggunaan_data_flag = $double->profil->penggunaan_data_flag;

                                    //update penggunaan data
                                    //jika penggunaan data pada kampung master kosong dan penggunaan data pada kampung double tidak kosong maka mapping
                                    //masukkan jumlah data di kampung double ke kampung master
                                    $datas = null;
                                    if(empty($kampungMaster->profil->profil_penggunaan_datas) || (!empty($double->profil->profil_penggunaan_datas)) ){
                                        $datas = $double->profil->penggunaan_datas->mapWithKeys(function($query) use($kampungMaster){
                                            return [
                                                $query->id => [
                                                    "profil_id" => $kampungMaster->profil->id,
                                                    "penggunaan_data_id" => $query->pivot->penggunaan_data_id,
                                                ]
                                            ];
                                        });

                                    }
                                    //bandingkan jumlah penggunaan data jika kampung master tidak kosong
                                    //masukkan jumlah data di kampung double ke kampung master
                                    if(!empty($kampungMaster->profil->profil_penggunaan_datas) && !empty($double->profil->profil_penggunaan_datas)){

                                        if(sizeof($kampungMaster->profil->profil_penggunaan_datas) < sizeof($double->profil->profil_penggunaan_datas)){

                                            $datas = $double->profil->penggunaan_datas->mapWithKeys(function($query) use($kampungMaster){
                                                return [
                                                    $query->id => [
                                                        "profil_id" => $kampungMaster->profil->id,
                                                        "penggunaan_data_id" => $query->pivot->penggunaan_data_id,
                                                    ]
                                                ];
                                            });
                                        }

                                    }

                                    if($datas !== null){
                                        $kampungMaster->profil->penggunaan_datas()->sync($datas);
                                    }

                                }

                                $kampungMaster->profil->save();

                                #insert latest update dari data double ke master
                                // $profilInsert = $double->profil->toArray();
                                // $profilInsert['kampung_kb_id'] = $masterId;
                                // $profil = ProfilKampung::create($profilInsert);

                                #insert relation profil
                                // 'profil_programs',
                                if(!empty($double->profil->programs)){
                                    $programs = $double->profil->programs->mapWithKeys(function($program) use($kampungMaster){

                                        $program_flag = $kampungMaster->profil->profil_programs->where('program_id', '=', $program->id)->first()->program_flag;
                                        return [
                                            $program->id => [
                                                "profil_id" => $kampungMaster->profil->id,
                                                "program_flag" => ($program_flag === true && !$program->pivot->program_flag) ? $program_flag : $program->pivot->program_flag,
                                            ]
                                        ];
                                    });

                                    $kampungMaster->profil->programs()->sync($programs);

                                }

                                // 'profil_operasionals',
                                if(!empty($double->profil->operasionals)){
                                    $operasionals = $double->profil->operasionals->mapWithKeys(function($query) use($kampungMaster){

                                        $operasional = $kampungMaster->profil->profil_operasionals->where('operasional_id', '=', $query->id)->first();
                                        return [
                                            $query->id => [
                                                "profil_id" => $kampungMaster->profil->id,
                                                "operasional_id" => $query->pivot->operasional_id,
                                                "operasional_flag" => ($operasional->operasional_flag && !$query->pivot->operasional_flag) ? $operasional->operasional_flag : $query->pivot->operasional_flag,
                                                "frekuensi_id" => ($operasional->frekuensi_id !== null && $query->pivot->frekuensi_id === null) ? $operasional->frekuensi_id : $query->pivot->frekuensi_id,
                                                "frekuensi_lainnya" => ($operasional->frekuensi_lainnya !== null && $query->pivot->frekuensi_lainnya === null) ? $operasional->frekuensi_lainnya : $query->pivot->frekuensi_lainnya,
                                            ]
                                        ];
                                    });
                                    $kampungMaster->profil->operasionals()->sync($operasionals);
                                }

                                // 'profil_sumber_danas',
                                if(!empty($double->profil->sumber_danas)){

                                    if(sizeof($kampungMaster->profil->profil_sumber_danas->toArray()) < sizeof($double->profil->profil_sumber_danas->toArray()))
                                    {
                                        $data = $double->profil->sumber_danas->mapWithKeys(function($query) use($kampungMaster){
                                            return [
                                                $query->id => [
                                                    "profil_id" => $kampungMaster->profil->id,
                                                    "sumber_dana_id" => $query->pivot->sumber_dana_id,
                                                ]
                                            ];
                                        });

                                        $kampungMaster->profil->sumber_danas()->sync($data);
                                    }

                                }

                            }
                        }

                    }

                    #penduduk
                    #jika penduduk master dan penduduk double ada maka update
                    if(!empty($double->penduduk) && !empty($kampungMaster->penduduk)) {

                        if(sizeof($double->penduduks->toArray()) > 1 && sizeof($kampungMaster->penduduks->toArray()) > 1)
                        {

                            #insert relation penduduk
                            // ranges,
                            if(!empty($double->penduduk->ranges)){
                                $data = $double->penduduk->penduduk_ranges->map(function($query) use($kampungMaster){

                                    $range = $kampungMaster->penduduk->penduduk_ranges
                                        ->where('range_id', $query->range_id)
                                        ->where('jenis_kelamin', $query->jenis_kelamin)
                                        ->first();
                                    return [
                                        "penduduk_kampung_id" => $kampungMaster->penduduk->id,
                                        "range_id" => $query->range_id,
                                        "jumlah" => $query->jumlah + ($range->jumlah ?? 0),
                                        "jenis_kelamin" => $query->jenis_kelamin,
                                    ];
                                });

                                $kampungMaster->penduduk->penduduk_ranges()->delete();
                                $kampungMaster->penduduk->penduduk_ranges()->createMany($data);
                            }

                            // keluargas,
                            if(!empty($double->penduduk->keluargas)){
                                $data = $double->penduduk->keluargas->mapWithKeys(function($query) use($kampungMaster){

                                    $keluarga = $kampungMaster->penduduk->keluargas
                                        ->where('id', $query->pivot->keluarga_id)
                                        ->first();
                                    return [
                                        $query->id => [
                                            "penduduk_kampung_id" => $kampungMaster->penduduk->id,
                                            "keluarga_id" => $query->pivot->keluarga_id,
                                            "jumlah" => $query->pivot->jumlah + ($keluarga->pivot->jumlah ?? 0),
                                        ]
                                    ];
                                });

                                $kampungMaster->penduduk->keluargas()->sync($data);
                            }
                        }

                    }

                    // #kkbpk
                    if((!empty($double->kkbpk) && empty($kampungMaster->kkbpk) ) || (!empty($double->kkbpk) && !empty($kampungMaster->kkbpk))){

                        //jika kkbkp masternya kosong dan kkbpk double ada maka insert dari data yang double
                        if(empty($kampungMaster->kkbpk) && !empty($double->kkbpk)){

                            #insert latest update dari data double ke master
                            $kkbpkInsert = $double->kkbpk->toArray();
                            $kkbpkInsert['kampung_kb_id'] = $masterId;
                            $kkbpk = Kkbpk::create($kkbpkInsert);

                            #update table relations
                            // programs
                            if(!empty($double->kkbpk->programs)){
                                $data = $double->kkbpk->programs->mapWithKeys(function($query) use($kkbpk){
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kkbpk->id,
                                            "program_id" => $query->pivot->program_id,
                                            "jumlah" => $query->pivot->jumlah,
                                        ]
                                    ];
                                });

                                $kkbpk->programs()->sync($data);
                            }

                            // kontrasepsis,
                            if(!empty($double->kkbpk->kontrasepsis)){
                                $data = $double->kkbpk->kontrasepsis->mapWithKeys(function($query) use($kkbpk){
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kkbpk->id,
                                            "kontrasepsi_id" => $query->pivot->kontrasepsi_id,
                                            "jumlah" => $query->pivot->jumlah,
                                        ]
                                    ];
                                });

                                $kkbpk->kontrasepsis()->sync($data);
                            }

                            // non kontrasepsis,
                            if(!empty($double->kkbpk->non_kontrasepsis)){
                                $data = $double->kkbpk->non_kontrasepsis->mapWithKeys(function($query) use($kkbpk){
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kkbpk->id,
                                            "non_kontrasepsi_id" => $query->pivot->non_kontrasepsi_id,
                                            "jumlah" => $query->pivot->jumlah,
                                        ]
                                    ];
                                });

                                $kkbpk->non_kontrasepsis()->attach($data);
                            }

                        }

                        //jika kkbkp masternya ada dan kkbpk double ada maka update master dan akumulasi jumlah double dengan master
                        if(!empty($kampungMaster->kkbpk) && !empty($double->kkbpk)){

                            //update status false untuk kkbpk master
                            $kampungMaster->kkbpk->pengguna_bpjs = ($kkbpkMaster->pengguna_bpjs ?? 0) + ($double->pengguna_bpjs ?? 0);
                            $kampungMaster->save();

                            #update table relations
                            // programs
                            if(!empty($double->kkbpk->programs)){

                                $data = $double->kkbpk->programs->mapWithKeys(function($query) use($kampungMaster){
                                    $program = $kampungMaster->kkbpk->programs()
                                        ->where('program_id', '=', $query->id)
                                        ->withPivot('jumlah')
                                        ->first();
                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kampungMaster->kkbpk->id,
                                            "jumlah" => ($query->pivot->jumlah ?? 0) + ($program->pivot->jumlah ?? 0),
                                        ]
                                    ];
                                });
                                $kampungMaster->kkbpk->programs()->sync($data);
                            }

                            // kontrasepsis
                            if(!empty($double->kkbpk->kontrasepsis)){
                                $data = $double->kkbpk->kontrasepsis->mapWithKeys(function($query) use($kampungMaster){

                                    $kontrasepsi = $kampungMaster->kkbpk->kontrasepsis()
                                        ->where('kontrasepsi_id', '=', $query->id)
                                        ->withPivot('jumlah')
                                        ->first();

                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kampungMaster->kkbpk->id,
                                            "kontrasepsi_id" => $query->pivot->kontrasepsi_id,
                                            "jumlah" => ($query->pivot->jumlah ?? 0) + ($kontrasepsi->pivot->jumlah ?? 0),
                                        ]
                                    ];

                                });

                                $kampungMaster->kkbpk->kontrasepsis()->sync($data);
                            }

                            // non kontrasepsis,
                            if(!empty($double->kkbpk->non_kontrasepsis)){
                                $data = $double->kkbpk->non_kontrasepsis->mapWithKeys(function($query) use($kampungMaster){

                                    $non_kontrasepsis = $kampungMaster->kkbpk->non_kontrasepsis()
                                        ->where('non_kontrasepsi_id', '=', $query->id)
                                        ->withPivot('jumlah')
                                        ->first();

                                    return [
                                        $query->id => [
                                            "kkbpk_kampung_id" => $kampungMaster->kkbpk->id,
                                            "non_kontrasepsi_id" => $query->pivot->non_kontrasepsi_id,
                                            "jumlah" => ($query->pivot->jumlah ?? 0) + ($non_kontrasepsis->pivot->jumlah ?? 0),
                                        ]
                                    ];
                                });

                                $kampungMaster->kkbpk->non_kontrasepsis()->sync($data);
                            }

                        }

                    }


                    $kampung = Kampung::find($double->id);
                    $kampung->is_active = false;
                    $kampung->save();

                    //insert rekap id kampung double
                    $double = array(
                        'kampung_id' => $masterId,
                        'kampung_id_double' => $double->id,
                        'merger_proses' => 'Merger Double By Regional',
                        'merger_kriteria' => $masterMerger['type']
                    );
                    KampungDouble::insert($double);

                    #update flag master
                    // $kampung = Kampung::find($masterId);
                    // $kampung->is_active = true;
                    // $kampung->save();

                    DB::commit();

                }catch(Throwable $e){

                    DB::rollback();

                }


            }

        // }

            // dd($doubles->toArray());
        }

    }

    public function max_attribute_in_array($data_points, $value='value'){
        $max=0;
        foreach($data_points as $point){
            if($max < (float)$point->{$value}){
                $max = $point->{$value};
            }
        }
        return $max;
    }
}
