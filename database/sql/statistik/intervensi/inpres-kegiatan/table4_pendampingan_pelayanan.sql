select a.id, a.name regional, b.*
from %1$s a
left join(
	select *,
		mengisi - (kegiatan_1 + kegiatan_2 + kegiatan_3) tidak_isi
	from
	(
		select a.*,
			(kegiatan_1 + kegiatan_2 + kegiatan_3 + tidak_kategori) - belum_isi mengisi,
			(kegiatan_1 + kegiatan_2 + kegiatan_3 + tidak_kategori) total
		from (
			select regional_id,
				sum(screening_kesehatan) screening_kesehatan,
				sum(pemberian_edukasi) pemberian_edukasi,
				sum(pendampingan_ibuhamil) pendampingan_ibuhamil,
				sum(pemeriksaan_anc) pemeriksaan_anc,
				sum(pemberian_tablet) pemberian_tablet,
				sum(kek) kek,
				sum(pemantauan_balita) pemantauan_balita,
				sum(makanan_anak_23_bulan) makanan_anak_23_bulan,
				sum(makanan_anak_59_bulan) makanan_anak_59_bulan,
				sum(gizi_buruk_balita) gizi_buruk_balita,
				sum(balita_gizi_kurang) balita_gizi_kurang,
				sum(kb_persalinan) kb_persalinan,
				sum(bantuan_pangan) bantuan_pangan,
				sum(pendampingan_ibu_keluarga) pendampingan_ibu_keluarga,
				sum(dashat) dashat,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 1 and 5 then 1 else 0 end) kegiatan_1,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 6 and 10 then 1 else 0 end) kegiatan_2,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 11 and 15 then 1 else 0 end) kegiatan_3,
				sum(tidak_kategori) tidak_kategori,
				sum(belum_isi) belum_isi
			from (
				select b.kampung_kb_id, %2$s.id regional_id ,
					sum(case when c.id = 21 then 1 else 0 end) screening_kesehatan,
					sum(case when c.id = 22 then 1 else 0 end) pemberian_edukasi,
					sum(case when c.id = 23 then 1 else 0 end) pendampingan_ibuhamil,
					sum(case when c.id = 24 then 1 else 0 end) pemeriksaan_anc,
					sum(case when c.id = 25 then 1 else 0 end) pemberian_tablet,
					sum(case when c.id = 26 then 1 else 0 end) kek,
					sum(case when c.id = 27 then 1 else 0 end) pemantauan_balita,
					sum(case when c.id = 28 then 1 else 0 end) makanan_anak_23_bulan,
					sum(case when c.id = 29 then 1 else 0 end) makanan_anak_59_bulan,
					sum(case when c.id = 30 then 1 else 0 end) gizi_buruk_balita,
					sum(case when c.id = 31 then 1 else 0 end) balita_gizi_kurang,
					sum(case when c.id = 32 then 1 else 0 end) kb_persalinan,
					sum(case when c.id = 33 then 1 else 0 end) bantuan_pangan,
					sum(case when c.id = 34 then 1 else 0 end) pendampingan_ibu_keluarga,
					sum(case when c.id = 35 then 1 else 0 end) dashat,
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
					where d.id = 4 --program 4
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

