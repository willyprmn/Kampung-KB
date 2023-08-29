SELECT c_crosstab('
	select a.id, a.name provinsi, COALESCE(tahun, ''Tahun_'') tahun, COALESCE(jumlah, 0) jumlah
	from %3$s a
	left join (
		select %1$s.id, %1$s.name regional, concat(''Tahun_'', cast(cast(case when date_part(''year'', tanggal_pencanangan) < 2016 then 2016 else date_part(''year'', tanggal_pencanangan) end as integer ) as text)) tahun
			, cast(count(tanggal_pencanangan) as integer) jumlah
		from new_kampung_kb a
		left join new_provinsi b on a.provinsi_id = b.id
		left join new_kabupaten c on a.kabupaten_id = c.id
		left join new_kecamatan d on a.kecamatan_id = d.id
		left join new_desa e on a.desa_id = e.id
		where 1=1 and a.is_active is true %2$s
		group by %1$s.id, %1$s.name, case when date_part(''year'', tanggal_pencanangan) < 2016 then 2016 else date_part(''year'', tanggal_pencanangan) end
		order by 1, 2
	)  b on b.id = a.id
	%4$s
	', 'ct_view', 'provinsi', 'tahun', 'jumlah', 'min',
	'id' --add column group by
);