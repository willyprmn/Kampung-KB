--=======================================================================
--PENDUDUK KAPUNG
--=======================================================================
--insert penduduk kampung
INSERT INTO new_penduduk_kampung(id, kampung_kb_id, created_at, created_by, is_active)
SELECT a.id_profil_penduduk, id_kkb, last_update, b.id created_by,
	CASE
		WHEN CAST(CAST(a.is_active AS INTEGER) AS BOOLEAN)
			AND a.id_profil_penduduk NOT IN (
				SELECT exc.id_profil_penduduk FROM profil_penduduk AS exc
				LEFT JOIN (
					SELECT MAX(id_profil_penduduk) as maxi, id_kkb
					FROM profil_penduduk
					WHERE is_active = 1
					GROUP BY id_kkb, is_active
					HAVING count(*) > 1
				) as deriv ON deriv.id_kkb = exc.id_kkb
				WHERE exc.is_active = 1
					AND exc.id_profil_penduduk != deriv.maxi
			)
		THEN true
		ELSE null
	END AS is_active
FROM profil_penduduk a
LEFT JOIN users b ON CAST(a.updater_id AS INTEGER) = b.id
;

SELECT setval('new_penduduk_kampung_id_seq', max(id)) FROM new_penduduk_kampung;