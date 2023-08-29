SELECT
A.ID ID_PROVINSI, A.name provinsi
, COALESCE(B.JUMLAH_KECAMATAN,0) TARGET_KKB
, COALESCE(C.JUMLAH_CAPAIAN,0) CAPAIAN_KKB
FROM new_provinsi A
LEFT JOIN
(
    SELECT SUBSTRING(A.ID,1,2) ID, COUNT(1) JUMLAH_KECAMATAN
    FROM new_kecamatan A
    GROUP BY SUBSTRING(A.ID,1,2)
) B ON A.ID = B.ID
LEFT JOIN
(
    SELECT A.ID, COUNT(1) JUMLAH_CAPAIAN
    FROM
    (
        SELECT A.kecamatan_id, SUBSTRING(A.kecamatan_id,1,2) ID
        FROM new_kampung_kb A
        where a.is_active is not false
        GROUP BY A.kecamatan_id, SUBSTRING(A.kecamatan_id,1,2)
    ) A
    GROUP BY A.ID
) C ON A.ID = C.ID
WHERE 1=1
order by a.name
