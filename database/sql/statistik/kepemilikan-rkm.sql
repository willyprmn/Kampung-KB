select regional_id, regional,
    ada,
    case when(total > 0) then ROUND( ((ada/ total::float)*100)::decimal, 2 ) else 0 end ada_persen,
    belum_ada,
    case when(total > 0) then ROUND( ((belum_ada/ total::float)*100)::decimal, 2 ) else 0 end belum_ada_persen,
    tidak_ada,
    case when(total > 0) then ROUND( ((tidak_ada/ total::float)*100)::decimal, 2 ) else 0 end tidak_ada_persen,
    total
from
(
    select a.id AS regional_id, a.name regional, b.*, (ada + belum_ada + tidak_ada) total
	from %1$s a
    left join (
        select %2$s.id, %2$s.name,
            sum(case when b.rencana_kerja_masyarakat_flag is true then 1 else 0 end) ada,
            sum(case when b.rencana_kerja_masyarakat_flag is false then 1 else 0 end) tidak_ada,
            sum(case when b.rencana_kerja_masyarakat_flag is null then 1 else 0 end) belum_ada
        from new_kampung_kb a
        left join (
            select * from new_profil_kampung 
            where 1=1 %5$s
        ) b on a.id = b.kampung_kb_id
        left join new_provinsi e on a.provinsi_id = e.id
        left join new_kabupaten f on a.kabupaten_id = f.id
		left join new_kecamatan g on a.kecamatan_id = g.id
		left join new_desa h on a.desa_id = h.id
        where a.is_active is true
        %3$s
        group by %2$s.id, %2$s.name
    ) b on a.id = b.id
    %4$s
) a
order by regional_id asc