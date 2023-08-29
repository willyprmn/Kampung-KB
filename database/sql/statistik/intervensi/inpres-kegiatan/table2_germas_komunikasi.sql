select a.id, a.name regional, b.*
from %1$s a
left join(
	select *,
		mengisi - (kegiatan_1 + kegiatan_2 + kegiatan_3) tidak_isi
	from
	(
		select a.*,
			--untuk mendapatkan jumlah yang sudah mengisi lakukan penjumlahan untuk kegiatan + tidak kegiatan dikurang belum mengisi
            --kategori 4 tidak dimasukan kedalam perhitungan karena kolom tersebut sudah termasuk dalam kolom kegiatan 1 s/d 3
			(kegiatan_1 + kegiatan_2 + kegiatan_3 + tidak_kategori) - belum_isi mengisi,
			--untuk mendapatkan total kampung, jumlahkan yg melakukan kegiatan dengan tidak berkategori
			(kegiatan_1 + kegiatan_2 + kegiatan_3 + tidak_kategori) total
		from (
			select regional_id,
				sum(germas) germas,
				sum(pispk) pispk,
				sum(bkb) bkb,
				sum(bkr) bkr,
				sum(bkl) bkl,
				sum(pikr) pikr,
				sum(edukasi_kie) edukasi_kie,
				sum(pengantin) pengantin,
				sum(keagamaan) keagamaan,
				sum(kie_pencegahan) kie_pencegahan,
				sum(advokasi_kie) advokasi_kie,
				sum(ktr) ktr,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 1 and 4 then 1 else 0 end) kegiatan_1,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 5 and 8 then 1 else 0 end) kegiatan_2,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 9 and 12 then 1 else 0 end) kegiatan_3,
				sum(case when  bkb > 0 and bkr > 0 and bkl > 0 and pikr > 0 then 1 else 0 end) kegiatan_4,
				sum(tidak_kategori) tidak_kategori,
				sum(belum_isi) belum_isi
			from (
				select b.kampung_kb_id, %2$s.id regional_id ,
					sum(case when c.id = 3 then 1 else 0 end) germas,
					sum(case when c.id = 4 then 1 else 0 end) pispk,
					sum(case when c.id = 5 then 1 else 0 end) bkb,
					sum(case when c.id = 6 then 1 else 0 end) bkr,
					sum(case when c.id = 7 then 1 else 0 end) bkl,
					sum(case when c.id = 8 then 1 else 0 end) pikr,
					sum(case when c.id = 9 then 1 else 0 end) edukasi_kie,
					sum(case when c.id = 10 then 1 else 0 end) pengantin,
					sum(case when c.id = 11 then 1 else 0 end) keagamaan,
					sum(case when c.id = 12 then 1 else 0 end) kie_pencegahan,
					sum(case when c.id = 13 then 1 else 0 end) advokasi_kie,
					sum(case when c.id = 14 then 1 else 0 end) ktr,
					count(*) jumlah_kegiatan,
					sum(case when bb.kampung_kb_id is null then 1 else 0 end) belum_isi,
					sum(case when b.kampung_kb_id is null then 1 else 0 end) tidak_kategori --jumlah ini termasuk belum isi dan tidak dalam kategori IN
				from new_kampung_kb a
				left join (
					select distinct inpres_kegiatan_id, kampung_kb_id 
					from new_kampung_kb a
					left join new_intervensi b on a.id = b.kampung_kb_id
					left join new_inpres_kegiatans c on b.inpres_kegiatan_id = c.id
					left join new_inpres_programs d on c.inpres_program_id = d.id
					where d.id = 2 --program 2
					and a.is_active is true 
					%5$s
				) b on a.id = b.kampung_kb_id
				left join (
					select distinct kampung_kb_id from new_intervensi
					%5$s
				) bb on a.id = bb.kampung_kb_id
				left join new_inpres_kegiatans c on b.inpres_kegiatan_id = c.id
				left join new_provinsi d on a.provinsi_id = d.id
				left join new_kabupaten e on a.kabupaten_id = e.id
				left join new_kecamatan f on a.kecamatan_id = f.id
				left join new_desa g on a.desa_id = g.id
				where is_active is true %3$s
				group by %2$s.id, b.kampung_kb_id
			) a
			group by regional_id
		) a
	) a
) b on a.id = b.regional_id
%4$s
order by a.id

