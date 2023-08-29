--insert profil keluarga
insert into new_penduduk_keluarga(penduduk_kampung_id, keluarga_id, jumlah)
--Pasangan Usia Subur
	select a.id_profil_penduduk, b.id, coalesce(pasangan_usia_subur, 0)
	from profil_penduduk a
	left join new_keluarga b on b.name = 'Pasangan Usia Subur'
	union all
--Jumlah Keluarga
	select a.id_profil_penduduk, b.id, coalesce(keluarga, 0)
	from profil_penduduk a
	left join new_keluarga b on b.name = 'Jumlah Keluarga'
	union all
--Jumlah Remaja
	select a.id_profil_penduduk, b.id, coalesce(jumlah_remaja, 0)
	from profil_penduduk a
	left join new_keluarga b on b.name = 'Jumlah Remaja'
	union all
--Keluarga yang Memiliki Balita
	select a.id_profil_penduduk, b.id, coalesce(balita, 0)
	from profil_penduduk a
	left join new_keluarga b on b.name = 'Keluarga yang Memiliki Balita'
	union all
--Keluarga yang Memiliki Remaja
	select a.id_profil_penduduk, b.id, coalesce(remaja, 0)
	from profil_penduduk a
	left join new_keluarga b on b.name = 'Keluarga yang Memiliki Remaja'
	union all
--Keluarga yang Memiliki Lansia
	select a.id_profil_penduduk, b.id, coalesce(lansia, 0)
	from profil_penduduk a
	left join new_keluarga b on b.name = 'Keluarga yang Memiliki Lansia'
;

SELECT setval('new_penduduk_keluarga_id_seq', max(id)) FROM new_penduduk_keluarga;