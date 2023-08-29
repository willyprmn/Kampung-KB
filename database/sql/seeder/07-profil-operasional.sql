--insert profil operasional
--UNTUK CEK DOUBLE ID PROFIL SARPRAS PADA MEKANISME OPERASIONAL
--select * from MEKANISME_OPERASIONAL where ID_PROFIL_SARPRAS in (
--select a.ID_PROFIL_SARPRAS from MEKANISME_OPERASIONAL a
--group by a.ID_PROFIL_SARPRAS
--having count(1) > 1
--)
insert into new_profil_operasional(profil_id, operasional_id, operasional_flag, frekuensi_id, frekuensi_lainnya)

	select a.id_profil_sarpras,
		e.id operasion_id,
		cast(case when rapat_perencanaan = 1 then true when rapat_perencanaan = 0 then false else null end as boolean) operasional_flag,
		case when rapat_perencanaan = 0 or rapat_perencanaan is null then null
			when d.id is not null then d.id
			else (select id from new_frekuensi x where x.name = 'Lainnya')
		end frekuensi_id,
		case when d.id is not null then null else f_rapat_perencanaan end frekuensi_lainnya
		from public.profil_sarana_prasarana a
		--left join dukungan_kkb b on a.id_profil_sarpras = b.id_profil_sarpras
		left join (select * from mekanisme_operasional x
			where x.id_mekanisme_operasional not in
			(
				select min(id_mekanisme_operasional) id
					from mekanisme_operasional --where id_profil_sarpras = 107162
				group by id_profil_sarpras
				having count(1) > 1
			)
	  	) c on a.id_profil_sarpras = c.id_profil_sarpras
		left join new_frekuensi d on c.f_rapat_perencanaan = d.name
		left join new_operasional e on e.name = 'Rapat perencanaan kegiatan'
		--where a.id_kkb = 1099 and a.is_active = 1
	union all
	select a.id_profil_sarpras,
		e.id operasion_id,
		cast(case when rakor_dinas = 1 then true when rakor_dinas = 0 then false else null end as boolean) operasional_flag,
		case when rakor_dinas = 0 or rakor_dinas is null then null
			when d.id is not null then d.id
			else (select id from new_frekuensi x where x.name = 'Lainnya')
		end frekuensi_id,
		case when d.id is not null then null else f_rakor_dinas end frekuensi_lainnya
		from public.profil_sarana_prasarana a
		--left join dukungan_kkb b on a.id_profil_sarpras = b.id_profil_sarpras
		left join (select * from mekanisme_operasional x
			where x.id_mekanisme_operasional not in
			(
				select min(id_mekanisme_operasional) id
					from mekanisme_operasional --where id_profil_sarpras = 107162
				group by id_profil_sarpras
				having count(1) > 1
			)
	  	) c on a.id_profil_sarpras = c.id_profil_sarpras
		left join new_frekuensi d on c.f_rakor_dinas = d.name
		left join new_operasional e on e.name = 'Rapat koordinasi dengan dinas/instansi terkait pendukung kegiatan'
		--where a.id_kkb = 1099 and a.is_active = 1
	union all
	select a.id_profil_sarpras,
		e.id operasion_id,
		cast(case when sosialisasi = 1 then true when sosialisasi = 0 then false else null end as boolean) operasional_flag,
		case when sosialisasi = 0 or sosialisasi is null then null
			when d.id is not null then d.id
			else (select id from new_frekuensi x where x.name = 'Lainnya')
		end frekuensi_id,
		case when d.id is not null then null else f_sosialisasi end frekuensi_lainnya
		from public.profil_sarana_prasarana a
		--left join dukungan_kkb b on a.id_profil_sarpras = b.id_profil_sarpras
		left join (select * from mekanisme_operasional x
			where x.id_mekanisme_operasional not in
			(
				select min(id_mekanisme_operasional) id
					from mekanisme_operasional --where id_profil_sarpras = 107162
				group by id_profil_sarpras
				having count(1) > 1
			)
	  	) c on a.id_profil_sarpras = c.id_profil_sarpras
		left join new_frekuensi d on c.f_sosialisasi = d.name
		left join new_operasional e on e.name = 'Sosialisasi Kegiatan'
		--where a.id_kkb = 1099 and a.is_active = 1
	union all
	select a.id_profil_sarpras,
		e.id operasion_id,
		cast(case when monitoring_evaluasi = 1 then true when monitoring_evaluasi = 0 then false else null end as boolean) operasional_flag,
		case when monitoring_evaluasi = 0 or monitoring_evaluasi is null then null
			when d.id is not null then d.id
			else (select id from new_frekuensi x where x.name = 'Lainnya')
		end frekuensi_id,
		case when d.id is not null then null else f_monitoring_evaluasi end frekuensi_lainnya
		from public.profil_sarana_prasarana a
		--left join dukungan_kkb b on a.id_profil_sarpras = b.id_profil_sarpras
		left join (select * from mekanisme_operasional x
			where x.id_mekanisme_operasional not in
			(
				select min(id_mekanisme_operasional) id
					from mekanisme_operasional --where id_profil_sarpras = 107162
				group by id_profil_sarpras
				having count(1) > 1
			)
	  	) c on a.id_profil_sarpras = c.id_profil_sarpras
		left join new_frekuensi d on c.f_monitoring_evaluasi = d.name
		left join new_operasional e on e.name = 'Monitoring dan Evaluasi Kegiatan'
		--where a.id_kkb = 1099 and a.is_active = 1
	union all
	select a.id_profil_sarpras,
		e.id operasion_id,
		cast(case when penyusunan_laporan = 1 then true when penyusunan_laporan = 0 then false else null end as boolean) operasional_flag,
		case when penyusunan_laporan = 0 or penyusunan_laporan is null then null
			when d.id is not null then d.id
			else (select id from new_frekuensi x where x.name = 'Lainnya')
		end frekuensi_id,
		case when d.id is not null then null else f_penyusunan_laporan end frekuensi_lainnya
		from public.profil_sarana_prasarana a
		--left join dukungan_kkb b on a.id_profil_sarpras = b.id_profil_sarpras
		left join (select * from mekanisme_operasional x
			where x.id_mekanisme_operasional not in
			(
				select min(id_mekanisme_operasional) id
					from mekanisme_operasional --where id_profil_sarpras = 107162
				group by id_profil_sarpras
				having count(1) > 1
			)
	  	) c on a.id_profil_sarpras = c.id_profil_sarpras
		left join new_frekuensi d on c.f_penyusunan_laporan = d.name
		left join new_operasional e on e.name = 'Penyusunan Laporan'
;

SELECT setval('new_profil_operasional_id_seq', max(id)) FROM new_profil_operasional;
