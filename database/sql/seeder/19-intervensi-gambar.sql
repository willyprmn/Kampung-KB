INSERT INTO new_intervensi_gambar (intervensi_id, caption, path, intervensi_gambar_type_id)
SELECT
	id_intervensi AS intervensi_id,
	(CASE WHEN nama IS NOT null THEN nama ELSE '-' END) AS caption,
	path,
	(
		CASE
	 		WHEN trim(type_gambar) = 'Kegiatan' THEN 1
			WHEN trim(type_gambar) = 'Sebelum' THEN 2
			WHEN trim(type_gambar) = 'Sesudah' THEN 3
            ELSE 1
		END
	) AS intervensi_gambar_type_id
FROM gambar_kegiatan
;

SELECT setval('new_intervensi_gambar_id_seq', max(id)) FROM new_intervensi_gambar;