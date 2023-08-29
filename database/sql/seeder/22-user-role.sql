INSERT INTO new_user_roles (user_id, role_id)
SELECT id AS user_id, 2 AS role_id FROM new_users
WHERE provinsi_id IS NULL
	AND kabupaten_id IS NULL
	AND kecamatan_id IS NULL
	AND desa_id IS NULL
;

INSERT INTO new_user_roles (user_id, role_id)
SELECT id AS user_id, 3 AS role_id FROM new_users
WHERE provinsi_id IS NOT NULL
	AND kabupaten_id IS NULL
	AND kecamatan_id IS NULL
	AND desa_id IS NULL
;

INSERT INTO new_user_roles (user_id, role_id)
SELECT id AS user_id, 4 AS role_id FROM new_users
WHERE provinsi_id IS NOT NULL
	AND kabupaten_id IS NOT NULL
	AND kecamatan_id IS NULL
	AND desa_id IS NULL
;

-- INSERT INTO new_user_roles (user_id, role_id)
-- SELECT id AS user_id, 4 AS role_id FROM new_users
-- WHERE provinsi_id IS NOT NULL
-- 	AND kabupaten_id IS NOT NULL
-- 	AND kecamatan_id IS  NOT NULL
-- 	AND desa_id IS NULL
-- ;

INSERT INTO new_user_roles (user_id, role_id)
SELECT id AS user_id, 5 AS role_id FROM new_users
WHERE provinsi_id IS NOT NULL
	AND kabupaten_id IS NOT NULL
	AND kecamatan_id IS  NOT NULL
	AND desa_id IS NOT NULL
;
