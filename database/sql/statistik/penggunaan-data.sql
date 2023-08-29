select regional nama,
    pemutahiran_data,
    case when(total_kampung > 0) then ROUND( ((pemutahiran_data / total_kampung::float)*100)::decimal, 2 ) else 0 end pemutahiran_data_persen,
	data_rutin,
    case when(total_kampung > 0) then ROUND( ((data_rutin / total_kampung::float)*100)::decimal, 2 ) else 0 end data_rutin_persen,
    potensi_desa,
    case when(total_kampung > 0) then ROUND( ((potensi_desa / total_kampung::float)*100)::decimal, 2 ) else 0 end potensi_desa_persen,
    data_sektoral,
    case when(total_kampung > 0) then ROUND( ((data_sektoral / total_kampung::float)*100)::decimal, 2 ) else 0 end data_sektoral_persen,
    lainnya,
    case when(total_kampung > 0) then ROUND( ((lainnya / total_kampung::float)*100)::decimal, 2 ) else 0 end lainnya_persen,
    tidak_ada,
    case when(total_kampung > 0) then ROUND( ((tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end tidak_ada_persen,
    belum_isi,
    case when(total_kampung > 0) then ROUND( ((belum_isi / total_kampung::float)*100)::decimal, 2 ) else 0 end belum_isi_persen,
    penggunaan_data_1,
    penggunaan_data_2,
    penggunaan_data_3,
	(penggunaan_data_1 + penggunaan_data_2 + penggunaan_data_3 + belum_isi + tidak_ada) total
from
(
	select regional_id, regional,
		sum(belum_isi) belum_isi,
		sum(tidak_ada) tidak_ada,
		sum(pemutahiran_data) pemutahiran_data,
		sum(data_rutin) data_rutin,
		sum(potensi_desa) potensi_desa,
		sum(data_sektoral) data_sektoral,
		sum(lainnya) lainnya,
		sum(case when total_data = 1 then 1 else 0 end) penggunaan_data_1,
		sum(case when total_data = 2 then 1 else 0 end) penggunaan_data_2,
		sum(case when total_data > 2 then 1 else 0 end) penggunaan_data_3,
		count(1) total_kampung
	from (
		select a.id regional_id, a.name regional, b.*
		from %1$s a
		left join (
			select %2$s.id, %2$s.name,
				sum(case when b.penggunaan_data_flag is null then 1 else 0 end) belum_isi,
				sum(case when b.penggunaan_data_flag is false or (b.penggunaan_data_flag is true and c.profil_id is null) then 1 else 0 end) tidak_ada,
				sum(case when b.penggunaan_data_flag is true and d.id = 1 then 1 else 0 end) pemutahiran_data,
				sum(case when b.penggunaan_data_flag is true and d.id = 2 then 1 else 0 end) data_rutin,
				sum(case when b.penggunaan_data_flag is true and d.id = 3 then 1 else 0 end) potensi_desa,
				sum(case when b.penggunaan_data_flag is true and d.id = 4 then 1 else 0 end) data_sektoral,
				sum(case when b.penggunaan_data_flag is true and d.id = 5 then 1 else 0 end) lainnya,
				count(c.profil_id) total_data
			from new_kampung_kb a
			left join (
				select * from new_profil_kampung 
				where 1=1 %5$s
			) b on a.id = b.kampung_kb_id
			left join new_profil_penggunaan_data c on b.id = c.profil_id
			left join new_penggunaan_data d on c.penggunaan_data_id = d.id
			left join new_provinsi e on a.provinsi_id = e.id
			left join new_kabupaten f on a.kabupaten_id = f.id
			left join new_kecamatan g on a.kecamatan_id = g.id
			left join new_desa h on a.desa_id = h.id
			where 1=1 and a.is_active is true %3$s
			group by %2$s.id, %2$s.name, c.profil_id
		) b on a.id = b.id
		%4$s
		order by a.id
	) a
	group by regional_id, regional
	order by regional_id
) a


