select a.name regional, b.*
from %1$s a
left join (

	select %2$s.id, %2$s.name,
		sum(bkb) bkb,
		sum(bkr) bkr,
		sum(bkl) bkl,
		sum(uppka) uppks,
		sum(pikr) pikr,
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
	left join new_provinsi e on a.provinsi_id = e.id
	left join new_kabupaten f on a.kabupaten_id = f.id
	left join new_kecamatan g on a.kecamatan_id = g.id
	left join new_desa h on a.desa_id = h.id
	where 1=1 and a.is_active is true %3$s
	group by %2$s.id, %2$s.name
) b on a.id = b.id
%4$s
order by a.id




