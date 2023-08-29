select a.id regional_id, a.name regional, b.*
from %1$s a
left join (

	select %2$s.id, %2$s.name,
		ROUND( ((sum(bkb)::float/ sum(memiliki_balita)::float)*100)::decimal, 2 ) bkb,
		ROUND( ((sum(bkr)::float/ sum(memiliki_remaja)::float)*100)::decimal, 2 ) bkr,
		ROUND( ((sum(bkl)::float/ sum(memiliki_lansia)::float)*100)::decimal, 2 ) bkl,
		ROUND( ((sum(uppka)::float/ sum(keluarga)::float)*100)::decimal, 2 ) uppks,
		ROUND( ((sum(pikr)::float/ sum(remaja)::float)*100)::decimal, 2 ) pikr,
		sum(case when b.kampung_kb_id is not null then 1 else 0 end) ada,
		sum(case when b.kampung_kb_id is null then 1 else 0 end) belum,
		count(1) total
	from new_kampung_kb a
	left join (

		select *, 
			case when (bkb is null and bkr is null and bkl is null and uppka is null and pikr is null) then null
				else COALESCE(bkb,0) + COALESCE(bkr,0) + COALESCE(bkl,0) + COALESCE(uppka,0) + COALESCE(pikr,0)
			end poktan_total
		from (
			select c.kampung_kb_id,
				sum(case when a.program_id = 1 then jumlah else 0 end) bkb,
				sum(case when a.program_id = 2 then jumlah else 0 end) bkr,
				sum(case when a.program_id = 3 then jumlah else 0 end) bkl,
				sum(case when a.program_id = 4 then jumlah else 0 end) uppka,
				sum(case when a.program_id = 5 then jumlah else 0 end) pikr
			from new_kkbpk_program a
			left join new_program b on a.program_id = b.id
			inner join (
				select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
				where 1=1 %5$s
				group by x.kampung_kb_id
			) c on a.kkbpk_kampung_id = c.id
			group by c.kampung_kb_id
		) a

	) b on a.id = b.kampung_kb_id
	left join (

		select *, 
			case when (keluarga is null and remaja is null and memiliki_balita is null and memiliki_remaja is null and memiliki_lansia is null) then null
				else COALESCE(keluarga,0) + COALESCE(remaja,0) + COALESCE(memiliki_balita,0) + COALESCE(memiliki_remaja,0) + COALESCE(memiliki_lansia,0)
			end penduduk_total
		from (
			select a.kampung_kb_id,
				sum(case when c.id = 2 then jumlah else 0 end) keluarga,
				sum(case when c.id = 3 then jumlah else 0 end) remaja,
				sum(case when c.id = 4 then jumlah else 0 end) memiliki_balita,
				sum(case when c.id = 5 then jumlah else 0 end) memiliki_remaja,
				sum(case when c.id = 6 then jumlah else 0 end) memiliki_lansia
			from (
				select kampung_kb_id, max(id) id
				from new_penduduk_kampung
				where 1=1 %5$s
				group by kampung_kb_id
			) a
			left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
			left join new_keluarga c on b.keluarga_id = c.id
			where b.keluarga_id != 1 -- exclude pasangan usia subur karena tidak di report statistik
			group by a.kampung_kb_id
		) a


	) c on a.id = c.kampung_kb_id
	left join new_provinsi e on a.provinsi_id = e.id
	left join new_kabupaten f on a.kabupaten_id = f.id
	left join new_kecamatan g on a.kecamatan_id = g.id
	left join new_desa h on a.desa_id = h.id
	where 1=1 and a.is_active is true %3$s
	group by %2$s.id, %2$s.name
) b on a.id = b.id
%4$s
order by a.id




