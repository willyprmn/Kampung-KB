select regional nama,
    bkb_ada,
    case when(total_kampung > 0) then ROUND( ((bkb_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end bkb_ada_persen,
    bkb_tidak_ada,
    case when(total_kampung > 0) then ROUND( ((bkb_tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end bkb_tidak_ada_persen,
	bkr_ada,
    case when(total_kampung > 0) then ROUND( ((bkr_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end bkr_ada_persen,
    bkr_tidak_ada,
    case when(total_kampung > 0) then ROUND( ((bkr_tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end bkr_tidak_ada_persen,
    bkl_ada,
    case when(total_kampung > 0) then ROUND( ((bkl_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end bkl_ada_persen,
    bkl_tidak_ada,
    case when(total_kampung > 0) then ROUND( ((bkl_tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end bkl_tidak_ada_persen,
    uppks_ada,
    case when(total_kampung > 0) then ROUND( ((uppks_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end uppks_ada_persen,
    uppks_tidak_ada,
    case when(total_kampung > 0) then ROUND( ((uppks_tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end uppks_tidak_ada_persen,
    pikr_ada,
    case when(total_kampung > 0) then ROUND( ((pikr_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end pikr_ada_persen,
    pikr_tidak_ada,
    case when(total_kampung > 0) then ROUND( ((pikr_tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end pikr_tidak_ada_persen,
    poktan_tidak_ada,
    case when(total_kampung > 0) then ROUND( ((poktan_tidak_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end poktan_tidak_ada_persen,
    poktan_belum_ada,
    case when(total_kampung > 0) then ROUND( ((poktan_belum_ada / total_kampung::float)*100)::decimal, 2 ) else 0 end poktan_belum_ada_persen,
    poktan_1_2,
	poktan_3_4,
	poktan_5,
	total_kampung total
from
(
    select a.name regional, b.*
    from %1$s a
    left join (
        select 
			%2$s.id, %2$s.name,
			sum(bkb_ada) bkb_ada,
			sum(bkb_tidak_ada) bkb_tidak_ada,
			sum(bkr_ada) bkr_ada,
			sum(bkr_tidak_ada) bkr_tidak_ada,
			sum(bkl_ada) bkl_ada,
			sum(bkl_tidak_ada) bkl_tidak_ada,
			sum(uppks_ada) uppks_ada,
			sum(uppks_tidak_ada) uppks_tidak_ada,
			sum(pikr_ada) pikr_ada,
			sum(pikr_tidak_ada) pikr_tidak_ada,
			sum(case when poktan_total = 0 then 1 else 0 end) poktan_tidak_ada,
			sum(case when poktan_total is null then 1 else 0 end) poktan_belum_ada,
			sum(case when poktan_total between 1 and 2 then 1 else 0 end) poktan_1_2,
			sum(case when poktan_total between 3 and 4 then 1 else 0 end) poktan_3_4,
			sum(case when poktan_total = 5 then 1 else 0 end) poktan_5,
			count(1) total_kampung
		from new_kampung_kb a
		left join (
			select kampung_kb_id, max(id) id
			from new_profil_kampung
			where 1=1 %5$s
			group by kampung_kb_id
		) b on a.id = b.kampung_kb_id
		left join ( --kepemilikan poktan
			select *, 
				(COALESCE(bkb_ada,0) + COALESCE(bkr_ada,0) + COALESCE(bkl_ada,0) + COALESCE(uppks_ada,0) + COALESCE(pikr_ada,0)) poktan_total
			from (
				select b.kampung_kb_id,
					sum(case when c.program_id = 1 and c.program_flag is true then 1 else 0 end) bkb_ada,
					sum(case when c.program_id = 1 and c.program_flag is false then 1 else 0 end) bkb_tidak_ada,
					sum(case when c.program_id = 2 and c.program_flag is true then 1 else 0 end) bkr_ada,
					sum(case when c.program_id = 2 and c.program_flag is false then 1 else 0 end) bkr_tidak_ada,
					sum(case when c.program_id = 3 and c.program_flag is true then 1 else 0 end) bkl_ada,
					sum(case when c.program_id = 3 and c.program_flag is false then 1 else 0 end) bkl_tidak_ada,
					sum(case when c.program_id = 4 and c.program_flag is true then 1 else 0 end) uppks_ada,
					sum(case when c.program_id = 4 and c.program_flag is false then 1 else 0 end) uppks_tidak_ada,
					sum(case when c.program_id = 5 and c.program_flag is true then 1 else 0 end) pikr_ada,
					sum(case when c.program_id = 5 and c.program_flag is false then 1 else 0 end) pikr_tidak_ada
				from (
					select kampung_kb_id, max(id) id
					from new_profil_kampung
					where 1=1 %5$s
					group by kampung_kb_id
				) b 
				left join new_profil_program c on b.id = c.profil_id
				group by b.kampung_kb_id
			) a
		) c on b.kampung_kb_id = c.kampung_kb_id 
		left join new_provinsi e on a.provinsi_id = e.id
		left join new_kabupaten f on a.kabupaten_id = f.id
		left join new_kecamatan g on a.kecamatan_id = g.id
		left join new_desa h on a.desa_id = h.id
		where 1=1 and a.is_active is true
		group by %2$s.id, %2$s.name

    )  b on a.id = b.id
    %4$s
    order by a.id
) a
