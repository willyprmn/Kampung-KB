--insert profil penggunaan_data
insert into new_profil_penggunaan_data(profil_id, penggunaan_data_id)
SELECT
	profil_sarana_prasarana.id_profil_sarpras AS profil_id,
	new_penggunaan_data.id
FROM profil_sarana_prasarana
LEFT JOIN dukungan_kkb
	ON profil_sarana_prasarana.id_profil_sarpras = dukungan_kkb.id_profil_sarpras
LEFT JOIN data_perencanaan
	ON dukungan_kkb.id_dukungan_kkb = data_perencanaan.id_dukungan_kkb
LEFT JOIN new_penggunaan_data
	ON new_penggunaan_data.name ILIKE '%' || data_perencanaan.data_perencanaan || '%'
WHERE new_penggunaan_data.id IS NOT null
GROUP BY
	profil_sarana_prasarana.id_profil_sarpras,
	new_penggunaan_data.id
ORDER BY profil_sarana_prasarana.id_profil_sarpras
;

SELECT setval('new_profil_penggunaan_data_id_seq', max(id)) FROM new_profil_penggunaan_data;