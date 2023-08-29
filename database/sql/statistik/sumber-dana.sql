select regional,
	apbd,
	ROUND(((apbd / total::float)*100)::decimal, 2) apbd_persen,
	apbn,
	ROUND(((apbn / total::float)*100)::decimal, 2) apbn_persen,
	dana_desa,
	ROUND(((dana_desa / total::float)*100)::decimal, 2) dana_desa_persen,
	donasi,
	ROUND(((donasi / total::float)*100)::decimal, 2) donasi_persen,
	perusahaan,
	ROUND(((perusahaan / total::float)*100)::decimal, 2) perusahaan_persen,
	swadaya,
	ROUND(((swadaya / total::float)*100)::decimal, 2) swadaya_persen,
	belum_isi,
	ROUND(((belum_isi / total::float)*100)::decimal, 2) belum_isi_persen,
	sumber_1,
	sumber_2,
	sumber_3,
	total
from (
	select *, (belum_isi + sumber_1 + sumber_2 + sumber_3) total
	from (
		select regional_id, regional,
			sum(apbd) apbd,
			sum(apbn) apbn,
			sum(dana_desa) dana_desa,
			sum(donasi) donasi,
			sum(perusahaan) perusahaan,
			sum(swadaya) swadaya,
			sum(belum_isi) belum_isi,
			sum(case when sumber = 1 then 1 else 0 end) sumber_1,
			sum(case when sumber between 2 and 4 then 1 else 0 end) sumber_2,
			sum(case when sumber > 4 then 1 else 0 end) sumber_3
		from (
			select a.id regional_id, a.name regional, b.*
			from %1$s a
			left join (
				select c.profil_id, %2$s.id, %2$s.name, count(c.profil_id) sumber
					,sum(case when c.profil_id is null then 1 else 0 end) belum_isi
					,sum(case when d.id = 1 then 1 else 0 end) apbd
					,sum(case when d.id = 2 then 1 else 0 end) apbn
					,sum(case when d.id = 3 then 1 else 0 end) dana_desa
					,sum(case when d.id = 4 then 1 else 0 end) donasi
					,sum(case when d.id = 5 then 1 else 0 end) perusahaan
					,sum(case when d.id = 6 then 1 else 0 end) swadaya
				from new_kampung_kb a
				left join (
					select kampung_kb_id, max(id) id
					from new_profil_kampung
					where 1=1 %5$s
					group by kampung_kb_id
				) b on a.id = b.kampung_kb_id
				left join new_profil_sumber_dana c on b.id = c.profil_id
				left join new_sumber_dana d on c.sumber_dana_id = d.id
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
) a
