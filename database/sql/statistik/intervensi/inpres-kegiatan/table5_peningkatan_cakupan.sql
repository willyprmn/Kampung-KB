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
				sum(pendidikan_paud) pendidikan_paud,
				sum(pendidikan_menengah) pendidikan_menengah,
				sum(pendikan_agama) pendikan_agama,
				sum(informasi_fasilitas) informasi_fasilitas,
				sum(bantuan_pendidikan) bantuan_pendidikan,
				sum(pendidikan_literasi) pendidikan_literasi,
				sum(wahana_kreatifitas) wahana_kreatifitas,
				sum(case kampung_kb_id is not null when jumlah_kegiatan between 1 and 2 then 1 else 0 end) kegiatan_1,
				sum(case kampung_kb_id is not null when jumlah_kegiatan between 3 and 5 then 1 else 0 end) kegiatan_2,
				sum(case kampung_kb_id is not null when jumlah_kegiatan between 6 and 7 then 1 else 0 end) kegiatan_3,
				sum(tidak_kategori) tidak_kategori,
				sum(belum_isi) belum_isi
			from (
				select b.kampung_kb_id, %2$s.id regional_id ,
					sum(case when c.id = 36 then 1 else 0 end) pendidikan_paud,
					sum(case when c.id = 37 then 1 else 0 end) pendidikan_menengah,
					sum(case when c.id = 38 then 1 else 0 end) pendikan_agama,
					sum(case when c.id = 39 then 1 else 0 end) informasi_fasilitas,
					sum(case when c.id = 40 then 1 else 0 end) bantuan_pendidikan,
					sum(case when c.id = 41 then 1 else 0 end) pendidikan_literasi,
					sum(case when c.id = 42 then 1 else 0 end) wahana_kreatifitas,
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
					where d.id = 5 --program 5
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

