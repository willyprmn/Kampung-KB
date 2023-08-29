--=======================================================================
--KKBPK KAMPUNG
--=======================================================================

--insert kkbpk kampung
insert into new_kkbpk_kampung (id, kampung_kb_id, bulan, tahun, pengguna_bpjs, created_at, created_by, is_active)
select a.id_kkbpk, id_kkb, bulan, tahun, coalesce(pengguna_bpjs, 0), last_update, b.id created_by,
	CASE
		WHEN CAST(CAST(a.is_active AS INTEGER) AS BOOLEAN)
			AND a.id_kkbpk NOT IN (
				SELECT exc.id_kkbpk FROM kkbpk AS exc
				LEFT JOIN (
					SELECT MAX(id_kkbpk) as maxi, id_kkb
					FROM kkbpk
					WHERE is_active = 1
					GROUP BY id_kkb, is_active
					HAVING count(*) > 1
				) as deriv ON deriv.id_kkb = exc.id_kkb
				WHERE exc.is_active = 1
					AND exc.id_kkbpk != deriv.maxi
			)
		THEN true
		ELSE null
	END AS is_active
from (
	select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
) a
left join users b on cast(a.updater_id as integer) = b.id
;

SELECT setval('new_kkbpk_kampung_id_seq', max(id)) FROM new_kkbpk_kampung;