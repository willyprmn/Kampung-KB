select a.id, a.name regional, b.*
from %1$s a
left join (
	select %2$s.id, %2$s.name,
		sum(anak_kemudian) anak_kemudian,
		ROUND( ((sum(anak_kemudian)::float/ sum(total_non_kontrasepsi)::float)*100)::decimal, 2 ) anak_kemudian_persen,
		sum(anak_segera) anak_segera,
		ROUND( ((sum(anak_segera)::float/ sum(total_non_kontrasepsi)::float)*100)::decimal, 2 ) anak_segera_persen,
		sum(hamil) hamil,
		ROUND( ((sum(hamil)::float/ sum(total_non_kontrasepsi)::float)*100)::decimal, 2 ) hamil_persen,
		sum(tidak_ingin_anak) tidak_ingin_anak,
		ROUND( ((sum(tidak_ingin_anak)::float/ sum(total_non_kontrasepsi)::float)*100)::decimal, 2 ) tidak_ingin_anak_persen,
		sum(case when b.kampung_kb_id is not null then 1 else 0 end) ada,
		sum(case when b.kampung_kb_id is null then 1 else 0 end) belum,
		sum(total_non_kontrasepsi) total_non_kontrasepsi,
		count(1) total,
		sum(pus) pus
	from new_kampung_kb a
	left join (

		select *, 
			case when (anak_kemudian is null and anak_segera is null and hamil is null and tidak_ingin_anak is null) then null
				else COALESCE(anak_kemudian,0) + COALESCE(anak_segera,0) + COALESCE(hamil,0) + COALESCE(tidak_ingin_anak,0)
			end total_non_kontrasepsi
		from (
			select c.kampung_kb_id,
				sum(case when a.non_kontrasepsi_id = 1 then jumlah else 0 end) hamil,
				sum(case when a.non_kontrasepsi_id = 2 then jumlah else 0 end) anak_segera,
				sum(case when a.non_kontrasepsi_id = 3 then jumlah else 0 end) anak_kemudian,
				sum(case when a.non_kontrasepsi_id = 4 then jumlah else 0 end) tidak_ingin_anak

			from new_kkbpk_non_kontrasepsi a
			left join new_non_kontrasepsi b on a.non_kontrasepsi_id = b.id
			inner join (
				select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
				where 1=1 %5$s
				group by x.kampung_kb_id
			) c on a.kkbpk_kampung_id = c.id
			group by c.kampung_kb_id
		) a

	) b on a.id = b.kampung_kb_id
	left join (
		select c.kampung_kb_id, b.id programs, jumlah pus
		from new_penduduk_keluarga a
		left join new_keluarga b on a.penduduk_kampung_id = b.id
		left join (
			select x.kampung_kb_id, max(id) id from new_penduduk_kampung x
			where 1=1 %5$s
			group by x.kampung_kb_id
		) c on a.penduduk_kampung_id = c.id
		where a.keluarga_id = 1 --pasangan usia subur
	) c on a.id = c.kampung_kb_id
	left join new_provinsi d on a.provinsi_id = d.id
	left join new_kabupaten e on a.kabupaten_id = e.id
	left join new_kecamatan f on a.kecamatan_id = f.id
	left join new_desa g on a.desa_id = g.id
	where 1=1 and a.is_active is true %3$s
	group by %2$s.id, %2$s.name
) b on a.id = b.id
%4$s
order by a.id
