--insert kkbpk non kontrasepsi
insert into new_kkbpk_non_kontrasepsi(kkbpk_kampung_id, non_kontrasepsi_id, jumlah)
--HAMIL
	select id_kkbpk, b.id kontrasepsi_id, coalesce(hamil, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_non_kontrasepsi b on b.id = 1
	union all
--IGIN SEGERA ANAK
	select id_kkbpk, b.id kontrasepsi_id, coalesce(ingin_anak_segera, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_non_kontrasepsi b on b.id = 2
	union all
--INGIN ANAK KEMUDIAN
	select id_kkbpk, b.id kontrasepsi_id, coalesce(ingin_anak_kemudian, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_non_kontrasepsi b on b.id = 3
	union all
--HAMIL
	select id_kkbpk, b.id kontrasepsi_id, coalesce(tidak_ingin_anak, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_non_kontrasepsi b on b.id = 4
;

SELECT setval('new_kkbpk_non_kontrasepsi_id_seq', max(id)) FROM new_kkbpk_non_kontrasepsi;