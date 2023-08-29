INSERT INTO new_intervensi (id
	, kampung_kb_id
	, jenis_post_id
	, judul, tanggal
	, tempat
	, deskripsi
	, kategori_id
	, program_id
	, created_at
	, updated_at
)
SELECT
	intervensi.id_intervensi AS id,
	id_kkb AS kampung_kb_id,
	new_jenis_post.id AS jenis_post_id,
	judul_kegiatan AS judul,
	tanggal_kegiatan AS tanggal,
	tempat_kegiatan AS tempat,
	intervensi.deskripsi,
	(
		CASE
			WHEN (SELECT EXISTS(
				SELECT 1
				FROM new_kategori
				WHERE new_kategori.name ILIKE '%' || intervensi.kategori_pilihan || '%'
					AND intervensi.kategori_pilihan != ''
			))
				THEN (
					SELECT new_kategori.id
					FROM new_kategori
					WHERE new_kategori.name ILIKE '%' || intervensi.kategori_pilihan || '%'
						AND intervensi.kategori_pilihan != ''
				)
			WHEN (SELECT EXISTS(SELECT 1 FROM new_kategori WHERE new_kategori.name ILIKE '%' || intervensi.kategori_intervensi || '%'))
				THEN (SELECT new_kategori.id FROM new_kategori WHERE new_kategori.name ILIKE '%' || intervensi.kategori_intervensi || '%')
			ELSE 9
		END
	) AS kategori_id,
	(
		CASE
			WHEN (
				SELECT EXISTS (
					SELECT 1
					FROM new_program
					LEFT JOIN new_program_group_details
						ON new_program.id = new_program_group_details.program_id
						AND new_program_group_details.program_group_id = '3' --intervensi
					WHERE new_program.name ILIKE '%' || intervensi.kategori_pilihan || '%'
						AND intervensi.kategori_pilihan != ''
				)
			)
				THEN (
					SELECT new_program.id
					FROM new_program
					LEFT JOIN new_program_group_details
						ON new_program.id = new_program_group_details.program_id
						AND new_program_group_details.program_group_id = '3' --intervensi
					WHERE new_program.name ILIKE '%' || intervensi.kategori_pilihan || '%'
						AND intervensi.kategori_pilihan != ''
				)
			WHEN (
				SELECT EXISTS (
					SELECT 1
					FROM new_program
					LEFT JOIN new_program_group_details
						ON new_program.id = new_program_group_details.program_id
						AND new_program_group_details.program_group_id = '3' --intervensi
					WHERE new_program.name ILIKE '%' || intervensi.kategori_intervensi || '%'
				)
			)
				THEN (
					SELECT new_program.id
					FROM new_program
					LEFT JOIN new_program_group_details
						ON new_program.id = new_program_group_details.program_id
						AND new_program_group_details.program_group_id = '3' --intervensi
					WHERE new_program.name ILIKE '%' || intervensi.kategori_intervensi || '%'
				)
			ELSE 10
		END
	) AS program_id,
	intervensi.created_at,
	intervensi.last_update AS updated_at
FROM intervensi
LEFT JOIN new_jenis_post
	ON new_jenis_post.name ILIKE '%' || intervensi.jenis_post || '%'
;

--ALTER SEQUENCE new_intervensi_id_seq RESTART WITH (SELECT setval('new_intervensi_id_seq', max(id)) FROM new_intervensi);