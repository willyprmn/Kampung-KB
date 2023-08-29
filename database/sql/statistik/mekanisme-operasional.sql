select regional,
    rapat_perencanaan,
    case when(total_kampung > 0) then ROUND( ((rapat_perencanaan / total_kampung::float)*100)::decimal, 2 ) else 0 end rapat_perencanaan_persen,
    rapat_koordinasi,
    case when(total_kampung > 0) then ROUND( ((rapat_koordinasi / total_kampung::float)*100)::decimal, 2 ) else 0 end rapat_koordinasi_persen,
    sosialisasi_kegiatan,
    case when(total_kampung > 0) then ROUND( ((sosialisasi_kegiatan / total_kampung::float)*100)::decimal, 2 ) else 0 end sosialisasi_kegiatan_persen,
    monitoring,
    case when(total_kampung > 0) then ROUND( ((monitoring / total_kampung::float)*100)::decimal, 2 ) else 0 end monitoring_persen,
    penyusunan_laporan,
    case when(total_kampung > 0) then ROUND( ((penyusunan_laporan / total_kampung::float)*100)::decimal, 2 ) else 0 end penyusunan_laporan_persen,
    tidak_ada,
    case when(total_kampung > 0) then ROUND( ((tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end tidak_ada_persen,
    belum_isi,
    case when(total_kampung > 0) then ROUND( ((belum_isi / total_kampung::float)*100)::decimal, 2 ) else 0 end belum_isi_persen,
    operasional_1,
    operasional_2,
    operasional_3,
	(operasional_1 + operasional_2 + operasional_3 + belum_isi + tidak_ada) total
from
(
	select regional,
		sum(case when total_operasional is null and profil_id is not null then 1 else 0 end) belum_isi,
		sum(case when total_operasional = 0 then 1 else 0 end) tidak_ada,
		sum(rapat_perencanaan) rapat_perencanaan,
		sum(rapat_koordinasi) rapat_koordinasi,
		sum(sosialisasi_kegiatan) sosialisasi_kegiatan,
		sum(monitoring) monitoring,
		sum(penyusunan_laporan) penyusunan_laporan,
		sum(case when total_operasional between 1 and 2 then 1 else 0 end) operasional_1,
		sum(case when total_operasional between 3 and 4 then 1 else 0 end) operasional_2,
		sum(case when total_operasional = 5 then 1 else 0 end) operasional_3,
		count(1) total_kampung
	from (
		select a.id regional_id, a.name regional, b.*
		from %1$s a
		left join (
			select %2$s.id, %2$s.name, c.profil_id, a.id AS kampung_counter,
				sum(case when c.profil_id is null then 1 else 0 end) belum_isi,
				sum(case when c.operasional_flag is true and d.id = 1 then 1 else 0 end) rapat_perencanaan,
				sum(case when c.operasional_flag is true and d.id = 2 then 1 else 0 end) rapat_koordinasi,
				sum(case when c.operasional_flag is true and d.id = 3 then 1 else 0 end) sosialisasi_kegiatan,
				sum(case when c.operasional_flag is true and d.id = 4 then 1 else 0 end) monitoring,
				sum(case when c.operasional_flag is true and d.id = 5 then 1 else 0 end) penyusunan_laporan,

				case when
					(sum(case when c.operasional_flag is null and d.id = 1 then 1 else 0 end) +
					sum(case when c.operasional_flag is null and d.id = 2 then 1 else 0 end) +
					sum(case when c.operasional_flag is null and d.id = 3 then 1 else 0 end) +
					sum(case when c.operasional_flag is null and d.id = 4 then 1 else 0 end) +
					sum(case when c.operasional_flag is null and d.id = 5 then 1 else 0 end) ) = 5 then null
				else
					sum(case when c.operasional_flag is true and d.id = 1 then 1 else 0 end) +
					sum(case when c.operasional_flag is true and d.id = 2 then 1 else 0 end) +
					sum(case when c.operasional_flag is true and d.id = 3 then 1 else 0 end) +
					sum(case when c.operasional_flag is true and d.id = 4 then 1 else 0 end) +
					sum(case when c.operasional_flag is true and d.id = 5 then 1 else 0 end)
				end
				total_operasional
			from new_kampung_kb a
			left join (
				select * from new_profil_kampung
				where 1=1 %5$s
			) b on a.id = b.kampung_kb_id
			left join new_profil_operasional c on b.id = c.profil_id
			left join new_operasional d on c.operasional_id = d.id
			left join new_provinsi e on a.provinsi_id = e.id
			left join new_kabupaten f on a.kabupaten_id = f.id
			left join new_kecamatan g on a.kecamatan_id = g.id
			left join new_desa h on a.desa_id = h.id
			where 1=1 and a.is_active is true %3$s
			group by %2$s.id, %2$s.name, c.profil_id, kampung_counter
		) b on a.id = b.id
		%4$s
		order by a.name
	) a
	group by regional_id, regional
	order by regional_id
) a


