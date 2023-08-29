
--=======================================================================
--PROFIL KAMPUNG
--=======================================================================

--profil_kampung
--UNTEK CEK ID PROFIL SARPRAS DOUBLE PADA DUKUNGAN KKB
--select * from dukungan_kkb where ID_PROFIL_SARPRAS in (
--select ID_PROFIL_SARPRAS from dukungan_kkb
--group by ID_PROFIL_SARPRAS having count(1) > 1
--)
insert into new_profil_kampung(id, kampung_kb_id, bulan, tahun,
	pokja_pengurusan_flag, pokja_sk_flag,
    pokja_pelatihan_flag, pokja_pelatihan_desc, pokja_jumlah, pokja_jumlah_terlatih,
	plkb_pendamping_flag, plkb_nip, plkb_nama, plkb_kontak,
	plkb_pengarah_id, plkb_pengarah_lainnya, regulasi_flag, regulasi_id, created_at,
	created_by, is_active, penggunaan_data_flag, rencana_kerja_masyarakat_flag
)
--saran dan prasaran
SELECT a.id_profil_sarpras, a.id_kkb, a.bulan, a.tahun,
	cast(case when (pokja_kkb = 1) then 1 when (pokja_kkb = 0) then 0 else null end as boolean) pokja_pengurusan_flag,
	cast(case when (sk_pokja_kkb = 1) then 1 when (sk_pokja_kkb = 0) then 0 else null end as boolean) pokja_sk_flag,
	cast(case when (sosialisasi_pokja_kkb = 1) then 1 when (sosialisasi_pokja_kkb = 0) then 0 else null end as boolean) pokja_pelatihan_flag,
	trim(detail_sosialisasi_pokja_kkb) pokja_pelatihan_desc, jumlah_pokja, jumlah_pokja_terlatih,
	cast(case when (c.id_dukungan_kkb is not null) then 1
		 when (d.id_dukungan_kkb is not null) then 0
		 else null
 	end as boolean) plkb_pendamping_flag,
	case when (c.id_dukungan_kkb is not null) then trim(c.nip)
		when  (d.id_dukungan_kkb is not null) then null
		else null
	end plkb_nip,
	case when (c.id_dukungan_kkb is not null) then trim(c.nama)
		when (d.id_dukungan_kkb is not null) then trim(d.nama)
		else null
	end plkb_nama,
	case when (c.id_dukungan_kkb is not null) then trim(c.kontak)
		when (d.id_dukungan_kkb is not null) then trim(d.kontak)
		else null
	end plkb_kontak,
	--pengarah plkb
	case when d.id_dukungan_kkb is not null then e.id
		else (select id from new_plkb_pengarah where name = 'Lainnya')
	end plkb_pengarah_id,
	case when e.id is not null then null
		else trim(d.tipe_pendamping)
	end pengarah_lainnya,
	--regulasi pemerintah
	case when b.regulasi_pemerintah = 1 and b.detail_regulasi_pemerintah is not null then true
		when b.regulasi_pemerintah = 0 then false
		else null
	end regulasi_flag,
	case when b.regulasi_pemerintah = 1 then f.id
		else null
	end regulasi_id,
	last_update created_at,
	CASE
		WHEN (SELECT EXISTS(SELECT 1 FROM users WHERE id = CAST(updater_id AS INTEGER)))
		THEN CAST(updater_id AS INTEGER)
		ELSE null
	END AS created_by,
	CASE
		WHEN CAST(CAST(a.is_active AS INTEGER) AS BOOLEAN)
			AND a.id_profil_sarpras NOT IN (
				SELECT exc.id_profil_sarpras FROM profil_sarana_prasarana AS exc
				LEFT JOIN (
					SELECT MAX(id_profil_sarpras) as latest, id_kkb
					FROM profil_sarana_prasarana
					WHERE is_active = 1
					GROUP BY id_kkb, is_active
					HAVING count(*) > 1
				) AS deriv
				ON deriv.id_kkb = exc.id_kkb
				WHERE exc.is_active = 1
					AND exc.id_profil_sarpras != deriv.latest
			)
		THEN true
		ELSE null
	END AS is_active,
	cast(case when b.penggunaan_data = 1 then true
			when b.penggunaan_data = 0 then false
		else null
	end as boolean) penggunaan_data_flag,
	cast(case when b.penggunaan_data = 1 then true
			when b.penggunaan_data = 0 then false
		else null
	end as boolean) rencana_kerja_masyarakat_flag
FROM public.profil_sarana_prasarana a
left join (select * from dukungan_kkb x
  where x.id_dukungan_kkb not in
	(
		select min(id_dukungan_kkb) id
		from dukungan_kkb --where id_profil_sarpras = 107162
		group by id_profil_sarpras
		having count(1) > 1
	)  --exclude id_dukungan_kkb ini double
) b on a.id_profil_sarpras = b.id_profil_sarpras
left join (select distinct id_dukungan_kkb, nip, nama, kontak from pendamping_plkb) c on b.id_dukungan_kkb = c.id_dukungan_kkb
left join pendamping_non_plkb d on b.id_dukungan_kkb = d.id_dukungan_kkb
left join new_plkb_pengarah e on case when (trim(d.tipe_pendamping) = 'Tidak Ada') then 'Lainnya' else '' end = e.name
left join new_regulasi f on trim(b.detail_regulasi_pemerintah) = f.name
;

SELECT setval('new_profil_kampung_id_seq', max(id), TRUE) FROM new_profil_kampung;

--INSERT REGULASI menjadi ONE TO MANY
insert into new_profil_regulasi(profil_id, regulasi_id)
--Sekretariat Kampung KB
	select a.id_profil_sarpras profil_id,
		case when b.regulasi_pemerintah = 1 and b.detail_regulasi_pemerintah is not null then f.id
			else null
		end regulasi_id
	from public.profil_sarana_prasarana a
	left join (select * from dukungan_kkb x
		where x.id_dukungan_kkb not in
			(
				select min(id_dukungan_kkb) id
				from dukungan_kkb --where id_profil_sarpras = 107162
				group by id_profil_sarpras
				having count(1) > 1
			)  --exclude id_dukungan_kkb ini double
		) b on a.id_profil_sarpras = b.id_profil_sarpras
	inner join new_regulasi f on trim(b.detail_regulasi_pemerintah) = f.name
	where b.regulasi_pemerintah = 1;

SELECT setval('new_profil_regulasi_id_seq', max(id), TRUE) FROM new_profil_kampung;
