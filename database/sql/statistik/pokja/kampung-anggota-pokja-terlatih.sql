select regional_id, regional,
    terlatih,
    case when(COALESCE(total, 0) > 0) then ROUND( ((COALESCE(terlatih,0) / COALESCE(total, 0)::float)*100)::decimal, 2 ) else 0 end terlatih_persen,
    tidak_terlatih,
    case when(COALESCE(total, 0) > 0) then ROUND( ((COALESCE(tidak_terlatih, 0)/ COALESCE(total, 0)::float)*100)::decimal, 2 ) else 0 end tidak_terlatih_persen,
    total
from
(
    select a.id AS regional_id, a.name regional, b.*
	from %1$s a
    left join (
		select a.id, a.name,
			COALESCE(a.pokja, 0) pokja,
			COALESCE(a.pokja_terlatih, 0) terlatih,
			(COALESCE(a.pokja) - COALESCE(a.pokja_terlatih)) tidak_terlatih,
			((COALESCE(a.pokja) - COALESCE(a.pokja_terlatih)) + COALESCE(a.pokja_terlatih, 0)) total
		from (
			select %2$s.id, %2$s.name,
				sum(case when b.pokja_pengurusan_flag is true and pokja_pelatihan_flag is true then pokja_jumlah else 0 end) pokja,
				sum(case when b.pokja_pengurusan_flag is true and pokja_pelatihan_flag is true then pokja_jumlah_terlatih else 0 end) pokja_terlatih
			from new_kampung_kb a
			left join new_profil_kampung b on a.id = b.kampung_kb_id
			inner join (
				select kampung_kb_id, max(id) id
				from new_profil_kampung
				where 1=1 %5$s
				group by kampung_kb_id
			) bb on b.id = bb.id
			left join new_provinsi c on a.provinsi_id = c.id
			left join new_kabupaten d on a.kabupaten_id = d.id
			left join new_kecamatan e on a.kecamatan_id = e.id
			left join new_desa f on a.desa_id = f.id
			where a.is_active is true
			and b.is_active is true
        	%3$s
			group by %2$s.id, %2$s.name
		) a
    ) b on a.id = b.id
	%4$s
) a
order by regional_id asc