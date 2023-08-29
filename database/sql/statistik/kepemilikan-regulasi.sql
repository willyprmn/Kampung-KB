select regional,
	sk_gubernur,
	ROUND(((sk_gubernur / total::float)*100)::decimal, 2) sk_gubernur_persen,
	sk_bupati,
	ROUND(((sk_bupati / total::float)*100)::decimal, 2) sk_bupati_persen,
	sk_kecamatan,
	ROUND(((sk_kecamatan / total::float)*100)::decimal, 2) sk_kecamatan_persen,
	sk_lurah,
	ROUND(((sk_lurah / total::float)*100)::decimal, 2) sk_lurah_persen,
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
			sum(sk_gubernur) sk_gubernur,
			sum(sk_bupati) sk_bupati,
			sum(sk_kecamatan) sk_kecamatan,
			sum(sk_lurah) sk_lurah,
			sum(belum_isi) belum_isi,
			sum(case when sumber = 1 then 1 else 0 end) sumber_1,
			sum(case when sumber between 2 and 3 then 1 else 0 end) sumber_2,
			sum(case when sumber > 3 then 1 else 0 end) sumber_3
		from (
			select a.id regional_id, a.name regional, b.*
			from %1$s a
			left join (
				select c.profil_id, %2$s.id, %2$s.name, count(c.profil_id) sumber
					,sum(case when c.profil_id is null then 1 else 0 end) belum_isi
					,sum(case when d.id = 1 then 1 else 0 end) sk_gubernur
					,sum(case when d.id = 2 then 1 else 0 end) sk_bupati
					,sum(case when d.id = 3 then 1 else 0 end) sk_kecamatan
					,sum(case when d.id = 4 then 1 else 0 end) sk_lurah
				from new_kampung_kb a
				left join (
					select kampung_kb_id, max(id) id
					from new_profil_kampung
					where 1=1 %5$s
					group by kampung_kb_id
				) b on a.id = b.kampung_kb_id
				left join new_profil_regulasi c on b.id = c.profil_id
				left join new_regulasi d on c.regulasi_id = d.id
				left join new_provinsi e on a.provinsi_id = e.id
				left join new_kabupaten f on a.kabupaten_id = f.id
				left join new_kecamatan g on a.kecamatan_id = g.id
				left join new_desa h on a.desa_id = h.id
				where 1=1 and a.is_active is true %3$s
				group by %2$s.id, %2$s.name, c.profil_id
			) b on a.id = b.id
			%4$s
			order by a.name
		) a
		group by regional_id, regional
		order by regional_id
	) a
) a
