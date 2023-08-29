--insert profil program
insert into new_profil_program(profil_id, program_id, program_flag)
--Sekretariat Kampung KB
	select a.id_profil_sarpras profil_id,
		(select 6) program_id,
		cast(case when sekertariat_kkb = 1 then true when sekertariat_kkb = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a

--BKB
	union all
	select a.id_profil_sarpras profil_id,
		(select 1) program_id,
		cast(case when bkb = 1 then true when bkb = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a
	--where a.id_kkb = 1099 and a.is_active = 1

--BKR
	union all
	select a.id_profil_sarpras profil_id,
		(select 2) program_id,
		cast(case when bkr = 1 then true when bkr = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a
	--where a.id_kkb = 1099 and a.is_active = 1

--BKL
	union all
	select a.id_profil_sarpras profil_id,
		(select 3) program_id,
		cast(case when bkl = 1 then true when bkl = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a
	--where a.id_kkb = 1099 and a.is_active = 1

--UPPKS
	union all
	select a.id_profil_sarpras profil_id,
		(select 4) program_id,
		cast(case when kel_uppks = 1 then true when kel_uppks = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a
	--where a.id_kkb = 1099 and a.is_active = 1

--PIKR
	union all
	select a.id_profil_sarpras profil_id,
		(select 5) program_id,
		cast(case when pik_r = 1 then true when pik_r = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a

--Rumah Dataku
	union all
	select a.id_profil_sarpras profil_id,
		(select 7) program_id,
		cast(case when rumah_dataku = 1 then true when rumah_dataku = 0 then false else null end as boolean) program_flag
	from public.profil_sarana_prasarana a

;


SELECT setval('new_profil_program_id_seq', max(id)) FROM new_profil_program;