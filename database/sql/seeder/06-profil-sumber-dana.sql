--insert profil sumber dana
insert into new_profil_sumber_dana(profil_id, sumber_dana_id)
SELECT DISTINCT
	profil_sarana_prasarana.id_profil_sarpras AS profil_id,
	new_sumber_dana.id AS sumber_dana_id
FROM profil_sarana_prasarana
LEFT JOIN dukungan_kkb
	ON dukungan_kkb.id_profil_sarpras = profil_sarana_prasarana.id_profil_sarpras
LEFT JOIN sumber_dana
	ON dukungan_kkb.id_dukungan_kkb = sumber_dana.id_dukungan_kkb
LEFT JOIN new_sumber_dana
	ON new_sumber_dana.name = sumber_dana.sumber_dana
WHERE new_sumber_dana.id IS NOT NULL
ORDER BY profil_id
;
--where a.sumber_dana ilike '%hibah%'

SELECT setval('new_profil_sumber_dana_id_seq', max(id)) FROM new_profil_sumber_dana;