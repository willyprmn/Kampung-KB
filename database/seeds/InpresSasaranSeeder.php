<?php

use Illuminate\Database\Seeder;
use App\Models\{
    InpresSasaran,
    InpresProgram,
    InpresKegiatan,
    Instansi,
    Keyword,
};

class InpresSasaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($inpres)
    {


        # Sasaran
        $sasaran1 = new InpresSasaran([
            'name' => 'Penyediaan data dan peningkatan cakupan administrasi kependudukan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $inpres->inpres_sasarans()->save($sasaran1);

        ## Program
        $program1 = new InpresProgram([
            'name' => 'Penyediaan data dan peningkatan cakupan pemenuhan administrasi kependudukan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $sasaran1->inpres_programs()->save($program1);

        ### Kegiatan
        $kegiatan1 = new InpresKegiatan([
            'name' => 'Rumah Data Kependudukan dan Informasi Keluarga (Rumah DataKu)',
            'indikator' => 'Tersedianya Rumah DataKu',
            'penanggung_jawab_id' => 1, #BKKBN
        ]);
        $program1->inpres_kegiatans()->save($kegiatan1);

        ####Keywords
        $keyword1 = Keyword::whereIn('name', [
            'rumah', 'data', 'pengumpulan', 'analisis', 'display', 'sarasehan', 'rembuk', 'penyediaan'
        ])->get()->pluck('id');
        $kegiatan1->keywords()->sync($keyword1);

        $kegiatan2 = new InpresKegiatan([
            'name' => 'Pelayanan administrasi kependudukan',
            'indikator' => 'Terpenuhinya layanan administrasi kependudukan bagi keluarga',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $program1->inpres_kegiatans()->save($kegiatan2);

        ####Keywords
        $keyword2 = Keyword::whereIn('name', [
            'administrasi', 'kependudukan', 'akta', 'akte', 'lahir', 'mati', 'kawin', 'nikah', 'cerai', 'pindah', 'KK', 'kartu', 'surat', 'buku', 'KTP', 'KIA','identitas'
        ])->get()->pluck('id');
        $kegiatan2->keywords()->sync($keyword2);

        # Sasaran
        $s2 = new InpresSasaran([
            'name' => 'Peningkatan perubahan perilaku',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $inpres->inpres_sasarans()->save($s2);

        ## Program
        $s2_p1 = new InpresProgram([
            'name' => 'Penguatan advokasi dalam Gerakan Masyarakat Hidup Sehat (GERMAS) dan komunikasi perubahan perilaku masyarakat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2->inpres_programs()->save($s2_p1);

        ### Kegiatan
        $s2_p1_k1a = new InpresKegiatan([
            'name' => 'Program Gerakan Masyarakat Hidup Sehat (GERMAS)',
            'indikator' => 'Persentase keluarga yang melaksanakan Perilaku Hidup Bersih dan Sehat (PHBS).',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k1a);

        ####Keywords
        $keyword_s2_p1_k1a = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'hidup', 'sehat', 'bersih', 'germas', 'olga', 'olah raga', 'konsumsi', 'sayur', 'buah', 'rokok', 'lingkungan', 'jamban', 'periksa', 'kesehatan'
        ])->get()->pluck('id');
        $s2_p1_k1a->keywords()->sync($keyword_s2_p1_k1a);

        $s2_p1_k1b = new InpresKegiatan([
            'name' => 'Program Indonesia Sehat dengan Pendekatan Keluarga (PISPK)',
            'indikator' => ' Jumlah kabupaten/kota yang telah melaksanakan PIS-PK dengan 100% intervensi keluarga',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k1b);

        ####Keywords
        $keyword_s2_p1_k1b = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'keluarga', 'berencana', 'KB', 'Persalinan', 'Faskes', 'RS', 'Puskesmas', 'klinik', 'Imunisasi', 'sehat', 'ASI', 'pertumbuhan', 'perkembangan', 'TBC', 'Paru', 'hipertensi', 'darting', 'darah', 'ODGJ', 'gila', 'gangguan jiwa', 'rokok', 'JKN', 'BPJS', 'jaminan', 'air bersih', 'jamban', 'periksa', 'kesehatan'
        ])->get()->pluck('id');
        $s2_p1_k1b->keywords()->sync($keyword_s2_p1_k1b);

        #request by Ibu Yusna, di split berdasarkan masing-masing program
        $s2_p1_k2 = new InpresKegiatan([
            'name' => 'Bina Keluarga Balita (BKB)',
            'indikator' => 'Persentase desa/kelurahan yang melaksanakan kelas Bina Keluarga Balita (BKB) tentang pengasuhan  1.000 Hari Pertama Kehidupan (HPK). Dan Persentase Keluarga Balita dan Anak yang Ikut BKB',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k2);

        ####Keywords
        $keyword_s2_p1_k2 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'keluarga', 'kelas', 'BKB', 'balita', '1000', 'HPK', 'poktan', 'hari', 'pertama', 'kehidupan'
        ])->get()->pluck('id');
        $s2_p1_k2->keywords()->sync($keyword_s2_p1_k2);

        $s2_p1_k2_2 = new InpresKegiatan([
            'name' => 'Bina Keluarga Remaja (BKR)',
            'indikator' => 'Persentase keluarga ikut pembinaan Bina Keluarga Remaja (BKR) ',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k2_2);

        ####Keywords
        $keyword_s2_p1_k2_2 = Keyword::whereIn('name', [
            // 'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'keluarga', 'BKB', 'balita', 'pola', 'asuh', 'poktan', 'partisipasi', 'ikut', 'anak', 'bayi', 'baduta'
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'keluarga', 'BKR', 'remaja', 'pola', 'asuh', 'poktan', 'partisipasi', 'ikut', 'konseling', 'edukasi', 'kespro', 'gizi', 'orang', 'tua', 'ortu'
        ])->get()->pluck('id');
        $s2_p1_k2_2->keywords()->sync($keyword_s2_p1_k2_2);


        $s2_p1_k2_3 = new InpresKegiatan([
            'name' => 'Bina Keluarga Lansia (BKL)',
            'indikator' => 'Persentase keluarga yang melaksanakan pendampingan bagi lansia',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k2_3);

        ####Keywords
        $keyword_s2_p1_k2_3 = Keyword::whereIn('name', [
            // 'pola', 'asuh', 'poktan', 'partisipasi', 'ikut', 'anak', 'bayi', 'baduta'
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'keluarga', 'BKL', 'lansia', 'tangguh', 'perawatan', 'poktan', 'partisipasi', 'ikut', 'tua'
        ])->get()->pluck('id');
        $s2_p1_k2_3->keywords()->sync($keyword_s2_p1_k2_3);

        $s2_p1_k2_4 = new InpresKegiatan([
            'name' => 'PIK Remaja',
            'indikator' => 'Persentase Pusat Informasi dan Konseling (PIK) Remaja dan Bina Keluarga Remaja (BKR) yang melaksanakan edukasi kesehatan reproduksi dan gizi bagi remaja.',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k2_4);

        ####Keywords
        $keyword_s2_p1_k2_4 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'keluarga', 'remaja', 'poktan', 'partisipasi', 'ikut', 'konseling', 'sebaya', 'edukasi', 'genre', 'PIKR', 'PIK-R', 'PIK_R', 'kespro', 'gizi', 'asertif', 'PKBR'
        ])->get()->pluck('id');
        $s2_p1_k2_4->keywords()->sync($keyword_s2_p1_k2_4);

        $s2_p1_k3 = new InpresKegiatan([
            'name' => 'Komunikasi, Informasi dan Edukasi (KIE) Kesehatan Reproduksi dan Keluarga Berencana bagi Keluarga',
            'indikator' => 'Terselenggaranya KIE Kesehatan Reproduksi dan Keluarga Berencana bagi Keluarga ',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k3);

        ####Keywords
        $keyword_s2_p1_k3 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'kespro', 'KB', 'kontrasepsi', 'poster', 'leaflet', 'film', 'lembar', 'balik', 'skata'
        ])->get()->pluck('id');
        $s2_p1_k3->keywords()->sync($keyword_s2_p1_k3);

        $s2_p1_k4 = new InpresKegiatan([
            'name' => 'Bimbingan Calon Pengantin',
            'indikator' => 'Terselenggaranya Bimbingan Calon Pengantin',
            'penanggung_jawab_id' => 4, #Kementerian Agama
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k4);

        ####Keywords
        $keyword_s2_p1_k4 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'bimbingan', 'konseling', 'catin', 'caten', 'nikah', 'kawin', 'stunting'
        ])->get()->pluck('id');
        $s2_p1_k4->keywords()->sync($keyword_s2_p1_k4);

        #nama kegiatan akan diubah (confirm ibu yusna)
        $s2_p1_k5 = new InpresKegiatan([
            'name' => 'Bimbingan, penyuluhan dan konsultasi keagamaan', 
            'indikator' => 'Persentase frekuensi penyuluhan agama kepada kelompok sasaran yang memenuhi standar minimal',
            'penanggung_jawab_id' => 4, #Kementerian Agama
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k5);

        ####Keywords
        $keyword_s2_p1_k5 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'bimbingan', 'konseling', 'penyuluhan', 'agama', 'nikah', 'kawin', 'keluarga', 'pengajian', 'sekolah minggu', 'ibadah'
        ])->get()->pluck('id');
        $s2_p1_k5->keywords()->sync($keyword_s2_p1_k5);

        $s2_p1_k6 = new InpresKegiatan([
            'name' => 'KIE Pencegahan, Perlindungan Perempuan dan Anak dari kekerasan',
            'indikator' => 'Terselenggaranya KIE Pencegahan, Perlindungan Perempuan dan Anak dari kekerasan',
            'penanggung_jawab_id' => 5, #Kementrian Pemberdayaan Perempuan dan Perlindungan Anak
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k6);

        ####Keywords
        $keyword_s2_p1_k6 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'bimbingan', 'konseling', 'penyuluhan', 'keluarga', 'perempuan', 'anak', 'perlindungan', 'kekerasan'
        ])->get()->pluck('id');
        $s2_p1_k6->keywords()->sync($keyword_s2_p1_k6);

        $s2_p1_k7 = new InpresKegiatan([
            'name' => 'Advokasi dan KIE pemberian makan bayi dan anak ASI eksklusif',
            'indikator' => 'Terselenggaranya Advokasi dan KIE pemberian makan bayi dan anak ASI eksklusif',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k7);

        ####Keywords
        $keyword_s2_p1_k7 = Keyword::whereIn('name', [
            'advokasi', 'sosialisasi', 'KIE', 'pelatihan', 'pendampingan', 'motivasi', 'bimbingan', 'konseling', 'penyuluhan', 'bayi', 'ASI', 'MPASI', 'makanan', 'anak'
        ])->get()->pluck('id');
        $s2_p1_k7->keywords()->sync($keyword_s2_p1_k7);

        $s2_p1_k8 = new InpresKegiatan([
            'name' => 'Kawasan Tanpa Rokok (KTR) dan implementasi Rumah Tanpa Asap Rokok',
            'indikator' => 'Tersedianya Kawasan Tanpa Rokok (KTR) dan implementasi Rumah Tanpa Asap Rokok',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s2_p1->inpres_kegiatans()->save($s2_p1_k8);

        ####Keywords
        $keyword_s2_p1_k8 = Keyword::whereIn('name', [
            'sosialisasi', 'KIE', 'motivasi', 'bimbingan', 'penyuluhan', 'asap', 'rokok'
        ])->get()->pluck('id');
        $s2_p1_k8->keywords()->sync($keyword_s2_p1_k8);
        




        # Sasaran
        $s3 = new InpresSasaran([
            'name' => 'Peningkatan cakupan layanan dan rujukan pada keluarga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $inpres->inpres_sasarans()->save($s3);

        ## Program
        $s3_p1 = new InpresProgram([
            'name' => 'Peningkatan akses dan pelayanan kesehatan termasuk Keluarga Berencana dan Kesehatan Reproduksi melalui program kesehatan berbasis masyarakat (PKBM)/unit-unit pelayanan dan Upaya Kesehatan Bersumberdaya Masyarakat (UKBM)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3->inpres_programs()->save($s3_p1);

        ### Kegiatan
        $s3_p1_k1 = new InpresKegiatan([
            'name' => 'Penggerakan Pelayanan Keluarga Berencana dan Kesehatan Reproduksi',
            'indikator' => 'Persentase Penyuluh KB yang berkinerja baik',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p1->inpres_kegiatans()->save($s3_p1_k1);

        ####Keywords
        $keyword_s3_p1_k1 = Keyword::whereIn('name', [
            'sosialisasi', 'KIE', 'motivasi', 'bimbingan', 'penyuluhan', 'pendampingan', 'PKB', 'PLKB', 'IMP', 'PPKBD', 'SubPPKBD', 'kader'
        ])->get()->pluck('id');
        $s3_p1_k1->keywords()->sync($keyword_s3_p1_k1);


        $s3_p1_k2 = new InpresKegiatan([
            'name' => 'Edukasi kesehatan ibu hamil, balita, remaja, dan lansia',
            'indikator' => 'Terselenggaranya kelas ibu hamil, kelas ibu balita, posyandu remaja, dan posyandu lansia',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p1->inpres_kegiatans()->save($s3_p1_k2);

        ####Keywords
        $keyword_s3_p1_k2 = Keyword::whereIn('name', [
            'sosialisasi', 'KIE', 'motivasi', 'bimbingan', 'penyuluhan', 'edukasi', 'pelatihan', 'pendampingan', 'bumil', 'bayi', 'balita', 'anak', 'remaja', 'PUS', 'WUS', 'lansia', 'kesehatan'
        ])->get()->pluck('id');
        $s3_p1_k2->keywords()->sync($keyword_s3_p1_k2);


        $s3_p1_k3a = new InpresKegiatan([
            'name' => 'Melakukan pembinaan posyandu',
            'indikator' => 'a.	Terselenggaranya pembinaan posyandu. b.	Terselenggaranya Posyandu Aktif',
            'penanggung_jawab_id' => 2, #Kementrian Dalam Negeri
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p1->inpres_kegiatans()->save($s3_p1_k3a);

        ####Keywords
        $keyword_s3_p1_k3a = Keyword::whereIn('name', [
            'motivasi', 'bimbingan', 'pelatihan', 'pendampingan', 'pembinaan', 'posyandu'
        ])->get()->pluck('id');
        $s3_p1_k3a->keywords()->sync($keyword_s3_p1_k3a);

        $s3_p1_k3b = new InpresKegiatan([
            'name' => 'b. Melaksanakan Posyandu Aktif',
            'indikator' => 'Terselenggaranya Posyandu Aktif',
            'penanggung_jawab_id' => 2, #Kementrian Dalam Negeri
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p1->inpres_kegiatans()->save($s3_p1_k3b);

        ####Keywords
        $keyword_s3_p1_k3b = Keyword::whereIn('name', [
            'sosialisasi', 'KIE', 'bimbingan', 'penyuluhan', 'pelatihan', 'pendampingan', 'posyandu', 'bumil', 'bayi', 'balita', 'lansia', 'kesehatan'
        ])->get()->pluck('id');
        $s3_p1_k3b->keywords()->sync($keyword_s3_p1_k3b);

        $s3_p1_k4 = new InpresKegiatan([
            'name' => 'Pelayanan Keluarga Berencana (KB) dan Kespro',
            'indikator' => 'Terselenggaranya pelayanan Keluarga Berencana (KB) dan Kespro',
            'penanggung_jawab_id' => 3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p1->inpres_kegiatans()->save($s3_p1_k4);

        ####Keywords
        $keyword_s3_p1_k4 = Keyword::whereIn('name', [
            'layanan', 'KB', 'Kespro', 'PIL', 'suntik', 'IUD', 'MOW', 'MOP', 'kondom', 'implan', 'implant', 'susuk', 'spiral', 'pendampingan'
        ])->get()->pluck('id');
        $s3_p1_k4->keywords()->sync($keyword_s3_p1_k4);


        $s3_p1_k5 = new InpresKegiatan([
            'name' => 'Pertemuan Peningkatan Kemampuan Keluarga (P2K2) dengan modul kesehatan dan gizi bagi Keluarga Penerima Manfaat (KPM) Program Keluarga Harapan',
            'indikator' => 'Terselenggaranya Pertemuan Peningkatan Kemampuan Keluarga (P2K2) dengan modul kesehatan dan gizi bagi Keluarga Penerima Manfaat (KPM) Program Keluarga Harapan',
            'penanggung_jawab_id' => 6, #Kementrian Sosial
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p1->inpres_kegiatans()->save($s3_p1_k5);

        ####Keywords
        $keyword_s3_p1_k5 = Keyword::whereIn('name', [
            'sosialisasi', 'KIE', 'bimbingan', 'penyuluhan', 'pelatihan', 'pendampingan', 'PKH', 'KPM'
        ])->get()->pluck('id');
        $s3_p1_k5->keywords()->sync($keyword_s3_p1_k5);



        ## Program
        $s3_p2 = new InpresProgram([
            'name' => 'Pendampingan dan pelayanan pada keluarga dengan resiko kejadian stunting',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3->inpres_programs()->save($s3_p2);

        ### Kegiatan
        $s3_p2_k1 = new InpresKegiatan([
            'name' => 'Screening kesehatan bagi calon pengantin ',
            'indikator' => 'Terselenggaranya screening kesehatan bagi calon pengantin',
            'penanggung_jawab_id' => 3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k1);

        $s3_p2_k2 = new InpresKegiatan([
            'name' => 'Pemberian pendampingan dan edukasi penatalaksanaan keluarga (relasi suami-istri, menyiapkan kehamilan, pengasuhan, pola konsumsi makanan sehat dan bergizi) bagi calon pasangan usia subur/ calon pengantian selama 3 bulan pra-nikah.',
            'indikator' => 'Terselenggaranya pemberian pendampingan dan edukasi penatalaksanaan keluarga bagi calon pasangan usia subur/calon pengantian selama 3 bulan pra-nikah.',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k2);

        $s3_p2_k3 = new InpresKegiatan([
            'name' => 'Pendampingan ibu hamil',
            'indikator' => 'Terlaksananya pemantauan ibu hamil yang mendapatkan ANC sesuai standar, penggunaan buku KIA, konsumsi TTD, dan makanan tambahan ibu hamil KEK',
            'penanggung_jawab_id' =>3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k3);

        $s3_p2_k4 = new InpresKegiatan([
            'name' => 'Pemeriksaaan  Antenatal Care (ANC) bagi ibu hamil',
            'indikator' => 'Terselenggaranya ANC bagi ibu hamil',
            'penanggung_jawab_id' => 3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k4);

        $s3_p2_k5 = new InpresKegiatan([
            'name' => 'Pemberian tablet tambah darah bagi remaja putri dan ibu hamil',
            'indikator' => 'Terselenggaranya pemberian tablet tambah darah bagi remaja putri dan ibu hamil',
            'penanggung_jawab_id' => 3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k5);

        $s3_p2_k6 = new InpresKegiatan([
            'name' => 'Pemberian tambahan asupan gizi bagi ibu hamil kurang energi kronik (KEK)',
            'indikator' => 'Terselenggaranya pemberian tambahan asupan gizi bagi ibu hamil KEK',
            'penanggung_jawab_id' => 3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k6);

        $s3_p2_k7 = new InpresKegiatan([
            'name' => 'Pemantauan pertumbuhan dan perkembangan anak berusia di bawah lima tahun (balita).',
            'indikator' => 'Terselenggaranya pemantauan pertumbuhan dan perkembangan anak balita.',
            'penanggung_jawab_id' => 3, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k7);

        $s3_p2_k8 = new InpresKegiatan([
            'name' => 'Pemberian makanan tambahan bagi anak usia 6 – 23 bulan',
            'indikator' => 'Terselenggaranya pemberian makanan tambahan bagi anak usia 6 – 23 bulan',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k8);

        $s3_p2_k8a = new InpresKegiatan([
            'name' => 'Pendampingan Baduta 24-59bulan dengan gizi kurang',
            'indikator' => 'Terselenggaranya Pendampingan Baduta 24-59bulan dengan gizi kurang',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k8a);

        $s3_p2_k9 = new InpresKegiatan([
            'name' => 'Penanganan tata laksana gizi buruk pada balita',
            'indikator' => 'Terlaksananya penanganan tata laksana gizi buruk pada balita',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k9);

        $s3_p2_k10 = new InpresKegiatan([
            'name' => 'Pemberian tambahan asupan gizi bagi balita dengan status gizi kurang',
            'indikator' => 'Terselenggaranya pemberian tambahan asupan gizi bagi balita dengan status gizi kurang',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k10);

        $s3_p2_k11 = new InpresKegiatan([
            'name' => 'Pelayanan KB pasca persalinan',
            'indikator' => 'Terselenggaranya pelayanan KB pasca persalinan',
            'penanggung_jawab_id' => 1, #BKKBN 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k11);

        $s3_p2_k12 = new InpresKegiatan([
            'name' => 'Pemberian bantuan pangan selain beras dan telur (variasi) (karbohidrat, protein hewani, protein nabati, vitamin dan mineral dan/atau Makanan Pendamping Air Susu Ibu, bagi ibu hamil, ibu menyusui dan baduta',
            'indikator' => 'Terselenggaranya pemberian bantuan pangan selain beras dan telur bagi ibu hamil, ibu menyusui dan baduta',
            'penanggung_jawab_id' => 1, #Kementrian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k12);

        $s3_p2_k13 = new InpresKegiatan([
            'name' => 'Pendampingan ibu/keluarga balita meliputi pemenuhan gizi, pengasuhan, dan pelayanan kesehatan',
            'indikator' => 'Terlaksananya pemantauan ibu/keluarga balita meliputi pemenuhan gizi, pengasuhan, pelayanan kesehatan, dan buku KIA',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k13);

        #DASHAT
        $s3_p2_k14 = new InpresKegiatan([
            'name' => 'Dapur Sehat Atasi Stunting (DASHAT)',
            'indikator' => 'Dapur Sehat Atasi Stunting (DASHAT)',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p2->inpres_kegiatans()->save($s3_p2_k14);
        

        ## Program
        $s3_p3 = new InpresProgram([
            'name' => 'Peningkatan cakupan dan akses pendidikan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3->inpres_programs()->save($s3_p3);

        ### Kegiatan
        $s3_p3_k1 = new InpresKegiatan([
            'name' => 'Pendidikan Anak Usia Dini (PAUD)',
            'indikator' => 'Terselenggaranya Pendidikan Anak Usia Dini (PAUD)',
            'penanggung_jawab_id' => 8, #Kementerian Pendidikan dan Kebudayaan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k1);

        $s3_p3_k2 = new InpresKegiatan([
            'name' => 'Pemberian Pendidikan Dasar dan Menengah',
            'indikator' => 'Tidak ada anak usia sekolah yang putus sekolah',
            'penanggung_jawab_id' => 8, #Kementerian Pendidikan dan Kebudayaan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k2);

        $s3_p3_k3 = new InpresKegiatan([
            'name' => 'Pendidikan dan layanan Agama bagi keluarga dan masyarakat',
            'indikator' => 'Terselenggaranya Pendidikan Agama bagi masyarakat ',
            'penanggung_jawab_id' => 4, #Kementerian Agama
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k3);

        $s3_p3_k4 = new InpresKegiatan([
            'name' => 'Pemberian informasi dan fasilitasi akses pelayanan pendidikan',
            'indikator' => 'Tersedianya informasi dan fasilitasi akses pelayanan pendidikan',
            'penanggung_jawab_id' => 8, #Kementerian Pendidikan dan Kebudayaan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k4);

        $s3_p3_k5 = new InpresKegiatan([
            'name' => 'Pemberian bantuan pendidikan bagi anak usia sekolah yang berasal dari keluarga dengan status miskin ',
            'indikator' => 'Tersedianya bantuan pendidikan bagi anak usia sekolah yang berasal dari keluarga dengan status miskin',
            'penanggung_jawab_id' => 8, #Kementerian Pendidikan dan Kebudayaan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k5);

        $s3_p3_k6 = new InpresKegiatan([
            'name' => 'Penyelenggaraan pendidikan literasi dalam pendidikan non formal',
            'indikator' => 'Terselenggaranya pendidikan literasi dalam pendidikan non formal',
            'penanggung_jawab_id' => 8, #Kementerian Pendidikan dan Kebudayaan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k6);

        $s3_p3_k7 = new InpresKegiatan([
            'name' => 'Penyelenggaraan wahana kreatifitas dan olahraga',
            'indikator' => 'Tersedianya wahana kretifitas dan olahraga',
            'penanggung_jawab_id' => 11, #Pemerintah Provinsi
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p3->inpres_kegiatans()->save($s3_p3_k7);




        ## Program
        $s3_p4 = new InpresProgram([
            'name' => 'Peningkatan cakupan layanan jaminan dan perlindungan sosial pada keluarga dan masyarakat miskin serta rentan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3->inpres_programs()->save($s3_p4);

        ### Kegiatan
        $s3_p4_k1 = new InpresKegiatan([
            'name' => 'Pemberian bantuan tunai bersyarat kepada Pasangan Usia Subur dengan status miskin dan penyandang masalah kesejahteraan sosial',
            'indikator' => 'Tersedianya bantuan tunai bersyarat kepada Pasangan Usia Subur dengan status miskin dan penyandang masalah kesejahteraan sosial',
            'penanggung_jawab_id' => 6, #Kementerian Sosial
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p4->inpres_kegiatans()->save($s3_p4_k1);

        $s3_p4_k2 = new InpresKegiatan([
            'name' => 'Pemberian bantuan pangan non-tunai kepada Pasangan Usia Subur dengan status miskin dan penyandang masalah kesejahteraan sosial ',
            'indikator' => 'Tersedianya bantuan pangan non-tunai kepada Pasangan Usia Subur dengan status miskin dan penyandang masalah kesejahteraan sosial ',
            'penanggung_jawab_id' => 6, #Kementerian Sosial
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p4->inpres_kegiatans()->save($s3_p4_k2);

        $s3_p4_k3 = new InpresKegiatan([
            'name' => 'Pemberian jaminan kesehatan kepada keluarga dengan status miskin dan penyandang masalah kesejahteraan sosial (Penerima Bantuan Iuran (PBI))',
            'indikator' => 'Tersedianya jaminan kesehatan kepada keluarga dengan status miskin dan penyandang masalah kesejahteraan sosial (Penerima Bantuan Iuran (PBI))',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p4->inpres_kegiatans()->save($s3_p4_k3);







        ## Program
        $s3_p5 = new InpresProgram([
            'name' => 'Pemberdayaan ekonomi keluarga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3->inpres_programs()->save($s3_p5);

        ### Kegiatan
        $s3_p5_k1 = new InpresKegiatan([
            'name' => 'Pemberian Program Keluarga Harapan kepada PUS dengan status miskin dan penyandang masalah kesejahteraan sosial',
            'indikator' => 'Terselenggaranya Program Keluarga Harapan kepada PUS dengan status miskin dan penyandang masalah kesejahteraan sosial',
            'penanggung_jawab_id' => 6, #Kementerian Sosial
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k1);

        #tidak diubah sesuai inpres baru (confirm ibu yusna)
        $s3_p5_k2 = new InpresKegiatan([
            'name' => 'Peningkatan kemampuan akses dan asset KPM Program Kewirausahaan Sosial',
            'indikator' => 'Persentase KPM yang meningkat kepemilikan aset produktifnya',
            'penanggung_jawab_id' => 6, #Kementerian Sosial
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k2);

        #tidak diubah sesuai inpres baru (confirm ibu yusna)
        $s3_p5_k3 = new InpresKegiatan([
            'name' => 'Peningkatan pendapatan dan kesejahteraan KPM Program Kewirausahaan Sosial',
            'indikator' => 'Persentase KPM yang meningkat kepemilikan aset produktifnya',
            'penanggung_jawab_id' => 6, #Kementerian Sosial
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k3);

        #tidak diubah sesuai inpres baru (confirm ibu yusna)
        $s3_p5_k4 = new InpresKegiatan([
            'name' => 'Penyelenggaraan bantuan permodalan',
            'indikator' => 'Jumlah penyaluran dana bergulir untuk koperasi',
            'penanggung_jawab_id' => 10, #Kementerian Koperasi dan UKM 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k4);

        #perubahan inpres baru
        $s3_p5_k4b = new InpresKegiatan([
            'name' => 'Promosi dan pemasaran koperasi dan umkm',
            'indikator' => 'Jumlah KUKM Mitra yang terlayani',
            'penanggung_jawab_id' => 10, #Kementerian Koperasi dan UKM 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k4b);

        $s3_p5_k5 = new InpresKegiatan([
            'name' => 'Pelatihan produksi dan pemasaran bagi usaha rumah tangga',
            'indikator' => 'Meningkatnya kualitas SDM koperasi dan UKM dalam mendukung usaha koperasi dan UKM yang berkelanjutan',
            'penanggung_jawab_id' => 10, #Kementerian Koperasi dan UKM
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k5);

        #dihapus berdasarkan inpres baru (confirm ibu yusna)
        // $s3_p5_k6 = new InpresKegiatan([
        //     'name' => 'Pelatihan daring marketing bagi usaha rumah tangga',
        //     'indikator' => 'Terselenggaranya Penyelenggaraan pelatihan online marketing bagi usaha rumah tangga',
        //     'penanggung_jawab_id' => 10, #Kementerian Koperasi dan UKM
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // $s3_p5->inpres_kegiatans()->save($s3_p5_k6);

        $s3_p5_k7 = new InpresKegiatan([
            'name' => 'Pengembangan Kampung Keluarga Berkualitas',
            'indikator' => 'Terbentuknya Kampung Keluarga Berkualitas',
            'penanggung_jawab_id' => 11, #Pemerintah Provinsi
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k7);

        $s3_p5_k8 = new InpresKegiatan([
            'name' => 'Meningkatnya kemandirian ekonomi keluarga',
            'indikator' => 'Persentase keluarga yang berwirausaha',
            'penanggung_jawab_id' => 1, #BKKBN
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k8);

        $s3_p5_k9 = new InpresKegiatan([
            'name' => 'Fasilitasi dan pembinaan pengembangan usaha nelayan',
            'indikator' => 'Jumlah nelayan yang difasilitasi dan dibina pengembangan usahanya',
            'penanggung_jawab_id' => 12, #Kementerian Kelautan dan Perikanan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k9);

        $s3_p5_k10 = new InpresKegiatan([
            'name' => 'Terkelolanya sistem pembenihan ikan yang berkelanjutan',
            'indikator' => 'Bantuan benih ikan air tawar, payau, dan air laut yang disalurkan ke masyarakat',
            'penanggung_jawab_id' => 12, #Kementerian Kelautan dan Perikanan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s3_p5->inpres_kegiatans()->save($s3_p5_k10);




        $s4 = new InpresSasaran([
            'name' => 'Penataan lingkungan keluarga dan masyarakat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $inpres->inpres_sasarans()->save($s4);

         ## Program
         $s4_p1 = new InpresProgram([
            'name' => 'Penataan lingkungan keluarga, peningkatan akses air minum, serta sanitasi dasar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s4->inpres_programs()->save($s4_p1);

        ## Kegiatan
        $s4_p1_k1 = new InpresKegiatan([
            'name' => 'Pemicuan Sanitasi Total Berbasis Masyarakat (STBM)',
            'indikator' => 'Terselenggaranya Sanitasi Total Berbasis Masyarakat (STBM)',
            'penanggung_jawab_id' => 14, #Kementerian Pekerjaan Umum dan Perumahan Rakyat
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s4_p1->inpres_kegiatans()->save($s4_p1_k1);

        #perubahan inpres baru (confirm iby yusna)
        $s4_p1_k2 = new InpresKegiatan([
            'name' => 'Penyediaan Akses Perumahan dan Infrastruktur Permukiman Yang Layak, Aman dan Terjangkau',
            'indikator' => 'Persentase peningkatan pelayanan infrastruktur permukiman yang layak dan aman melalui pendekatan smart living',
            'penanggung_jawab_id' => 14, #Kementerian Pekerjaan Umum dan Perumahan Rakyat
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s4_p1->inpres_kegiatans()->save($s4_p1_k2);

        $s4_p1_k3 = new InpresKegiatan([
            'name' => 'Pengendalian vektor dan binatang pembawa penyakit',
            'indikator' => 'Tersedianya juru pemantau jentik (jumantik) di keluarga',
            'penanggung_jawab_id' => 3, #Kementerian Kesehatan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $s4_p1->inpres_kegiatans()->save($s4_p1_k3);

    }
}
