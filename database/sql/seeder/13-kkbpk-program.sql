--insert kkbpk program
insert into new_kkbpk_program(kkbpk_kampung_id, program_id, jumlah)
--BKB
	select id_kkbpk, b.id program_id, coalesce(bkb, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_program b on b.name = 'BKB'
	union all
--BKR
	select id_kkbpk, b.id program_id, coalesce(bkr, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_program b on b.name = 'BKR'
	union all
--BKL
	select id_kkbpk, b.id program_id, coalesce(bkl, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_program b on b.name = 'BKL'
	union all
--UPPKS
	select id_kkbpk, b.id program_id, coalesce(uppks, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_program b on b.name = 'UPPKA'
	union all
--PIKR
	select id_kkbpk, b.id program_id, coalesce(pik, 0) AS jumlah
	from (
		select * from kkbpk x where x.id_kkb in (select id_kkb from kampung_kb)
	) a
	left join new_program b on b.name = 'PIK R'
;


SELECT setval('new_kkbpk_program_id_seq', max(id)) FROM new_kkbpk_program;