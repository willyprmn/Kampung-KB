--insert kkbpk kontrasepsi
insert into new_kkbpk_kontrasepsi(kkbpk_kampung_id, kontrasepsi_id, jumlah)
--MOP
	select id_kkbpk, b.id kontrasepsi_id, coalesce(mop, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'MOP'
	union all
--MOW
	select id_kkbpk, b.id kontrasepsi_id, coalesce(mow, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'MOW'
	union all
--IUD
	select id_kkbpk, b.id kontrasepsi_id, coalesce(iud, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'IUD'
	union all
--IMPLAN
	select id_kkbpk, b.id kontrasepsi_id, coalesce(implan, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'Implan'
	union all
--SUNTIK
	select id_kkbpk, b.id kontrasepsi_id, coalesce(suntik, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'Suntik'
	union all
--PIL
	select id_kkbpk, b.id kontrasepsi_id, coalesce(pil, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'PIL'
	union all
--KONDOM
	select id_kkbpk, b.id kontrasepsi_id, coalesce(kondom, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_kontrasepsi b on b.name = 'Kondom'
;

SELECT setval('new_kkbpk_kontrasepsi_id_seq', max(id)) FROM new_kkbpk_kontrasepsi;