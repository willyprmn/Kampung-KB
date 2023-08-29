--insert range usia
insert into new_penduduk_range(penduduk_kampung_id, range_id, jenis_kelamin, jumlah)
--USIA W 0-4
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_0_4, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 0 and b.range_end = 4
	union all
--USIA P 0-4
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_0_4, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 0 and b.range_end = 4
	union all
--USIA W 5-9
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_5_9, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 5 and b.range_end = 9
	union all
--USIA P 5-9
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_5_9, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 5 and b.range_end = 9
	union all
--USIA W 10-14
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_10_14, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 10 and b.range_end = 14
	union all
--USIA P 10-14
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_10_14, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 10 and b.range_end = 14
	union all
--USIA W 15-19
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_15_19, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 15 and b.range_end = 19
	union all
--USIA P 15-19
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_15_19, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 15 and b.range_end = 19
	union all
--USIA W 20-24
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_20_24, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 20 and b.range_end = 24
	union all
--USIA P 20-24
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_20_24, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 20 and b.range_end = 24
	union all
--USIA W 25-29
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_25_29, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 25 and b.range_end = 29
	union all
--USIA P 25-29
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_25_29, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 25 and b.range_end = 29
	union all
--USIA W 30-34
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_30_34, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 30 and b.range_end = 34
	union all
--USIA P 30-34
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_30_34, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 30 and b.range_end = 34
	union all
--USIA W 35-39
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_35_39, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 35 and b.range_end = 39
	union all
--USIA P 35-39
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_35_39, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 35 and b.range_end = 39
	union all
--USIA W 40-44
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_40_44, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 40 and b.range_end = 44
	union all
--USIA P 40-44
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_40_44, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 40 and b.range_end = 44
	union all
--USIA W 45-49
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_45_49, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 45 and b.range_end = 49
	union all
--USIA P 45-49
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_45_49, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 45 and b.range_end = 49
	union all
--USIA W 50-54
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_50_54, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 50 and b.range_end = 54
	union all
--USIA P 50-54
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_50_54, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 50 and b.range_end = 54
	union all
--USIA W 55-59
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_55_59, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 55 and b.range_end = 59
	union all
--USIA P 55-59
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_55_59, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 55 and b.range_end = 59
	union all
--USIA W 60+
	select a.id_profil_penduduk, b.id, 'W' jenis_kelamin, coalesce(w_60, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 60
	union all
--USIA P 60+
	select a.id_profil_penduduk, b.id, 'P' jenis_kelamin, coalesce(p_60, 0)
	from profil_penduduk a
	left join new_range b on b.range_start = 60
;

SELECT setval('new_penduduk_range_id_seq', max(id)) FROM new_penduduk_range;