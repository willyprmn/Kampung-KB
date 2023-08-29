SELECT c_crosstab(
    $$
    select regional_id, instansi, sum(jumlah) jumlah
    from (
        select distinct %2$s.id regional_id, %2$s.name regional,
            lower(case when alias is null then 'lainnya' else alias end) instansi
            , count(instansi_id) jumlah
        from new_kampung_kb a
        left join (
			select distinct b.kampung_kb_id, c.instansi_id
			from new_kampung_kb a
			left join new_intervensi b on a.id = b.kampung_kb_id
			inner join new_intervensi_instansi c on b.id = c.intervensi_id
            where 1=1 %5$s
		) b on a.id = b.kampung_kb_id 
        left join new_instansi d on b.instansi_id = d.id
        left join new_provinsi e on a.provinsi_id = e.id
        left join new_kabupaten f on a.kabupaten_id = f.id
		left join new_kecamatan g on a.kecamatan_id = g.id
		left join new_desa h on a.desa_id = h.id
		where a.is_active is true %3$s 
        group by %2$s.id, alias

    ) a
    group by regional_id, instansi, jumlah
    order by regional_id
    $$    
, 'ct_view', 'regional_id', 'instansi', 'jumlah', 'min', null);

