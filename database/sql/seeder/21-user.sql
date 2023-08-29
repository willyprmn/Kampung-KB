INSERT INTO new_users (id, siga_id, email, password, created_at, updated_at, provinsi_id, kabupaten_id, kecamatan_id, desa_id)
SELECT deriv_1.* FROM (
	SELECT id
	, ROW_NUMBER () OVER (ORDER BY name)
	, (CASE WHEN username IS NULL THEN 'null' || ROW_NUMBER () OVER (ORDER BY name) || '@bkkbn.go.id' ELSE username END) AS email
	, password
	, to_timestamp(created_on) AS created_at
    , to_timestamp(created_on) AS updated_at
	, (
		CASE
			WHEN CAST(location AS VARCHAR) = '-' THEN null
			WHEN
				CHAR_LENGTH(
					REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', '')
				) >= 2
			THEN LEFT(
				REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', ''),
				2
			)
			ELSE null
		END
	) AS provinsi_id
	, (
		CASE
			WHEN CAST(location AS VARCHAR) = '-' THEN null
			WHEN
				CHAR_LENGTH(
					REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', '')
				) >= 4
			THEN LEFT(
				REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', ''),
				4
			)
			ELSE null
		END
	) AS kabupaten_id
	, (
		CASE
			WHEN CAST(location AS VARCHAR) = '-' THEN null
			WHEN
				CHAR_LENGTH(
					REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', '')
				) >= 6
			THEN LEFT(
				REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', ''),
				6
			)
			ELSE null
		END
	) AS kecamatan_id
	, (
		CASE
			WHEN CAST(location AS VARCHAR) = '-' THEN null
			WHEN
				CHAR_LENGTH(
					REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', '')
				) >= 10
			THEN LEFT(
				REPLACE(CAST(location::JSON->'id' AS VARCHAR), '"', ''),
				10
			)
			ELSE null
		END
	) AS desa_id
	FROM users
) AS deriv_1
LEFT JOIN new_desa
 	ON deriv_1.desa_id = new_desa.id
-- WHERE deriv_1.desa_id IS NULL OR deriv_1.desa_id = new_desa.id
ORDER BY deriv_1.id ASC
;

SELECT setval('new_users_id_seq', max(id)) FROM new_users;