select *
from (
	select a.id, a.nama,
		prov.name provinsi,
		kab.name kabupaten,
		kec.name kecamatan,
		desa.name desa,
		--profile
		jumlah_sumber_dana,
		pokja_pengurusan_flag pokja_pengurusan,
		pokja_sk_flag pokja_sk,
		pokja_pelatihan_flag pokja_pelatihan,
		pokja_jumlah,
		pokja_jumlah_terlatih,
		plkb_pendamping_flag plkb_pendamping,
		--plkb_nip, plkb_nama, plkb_kontak,
		regulasi_flag regulasi, jumlah_regulasi,
		rencana_kerja_masyarakat_flag rkm,
		penggunaan_data_flag penggunaan_data,
		jumlah_operasional jumlah_mekanisme_operasional,

		coalesce(pus, 0) pus,
		coalesce(penduduk, 0) penduduk,
		coalesce(b.keluarga, 0) keluarga, coalesce(b.remaja, 0) remaja, coalesce(b.memiliki_balita, 0) memiliki_balita, coalesce(b.memiliki_remaja, 0) memiliki_remaja, coalesce(b.memiliki_lansia, 0) memiliki_lansia,
		coalesce(c.bkb, 0) bkb, coalesce(c.bkr, 0) bkr, coalesce(c.bkl, 0) bkl, coalesce(c.uppka, 0) uppka, coalesce(c.pikr, 0) pikr,
		--total poktan
		(coalesce(c.bkb, 0) + coalesce(c.bkr, 0) + coalesce(c.bkl, 0) + coalesce(c.uppka, 0) + coalesce(c.pikr, 0)) total_poktan,
		--partipasi poktan
		case when coalesce(c.bkb, 0) > 0 and coalesce(memiliki_balita, 0) > 0 then ROUND( ((bkb::float/ memiliki_balita::float)*100)::decimal, 2 ) else 0 end partisipasi_poktan_bkb,
		case when coalesce(c.bkr, 0) > 0 and coalesce(memiliki_remaja, 0) > 0 then ROUND( ((bkr::float/ memiliki_remaja::float)*100)::decimal, 2 ) else 0 end partisipasi_poktan_bkr,
		case when coalesce(c.bkl, 0) > 0 and coalesce(memiliki_lansia, 0) > 0 then ROUND( ((bkl::float/ memiliki_lansia::float)*100)::decimal, 2 ) else 0 end partisipasi_poktan_bkl,
		case when coalesce(c.uppka, 0) > 0 and coalesce(keluarga, 0) > 0 then ROUND( ((uppka::float/ keluarga::float)*100)::decimal, 2 ) else 0 end partisipasi_poktan_uppka,
		case when coalesce(c.pikr, 0) > 0 and coalesce(remaja, 0) > 0 then ROUND( ((pikr::float/ remaja::float)*100)::decimal, 2 ) else 0 end partisipasi_poktan_remaja,
		--kontrasepsi
		coalesce(d.iud, 0) iud, coalesce(d.mow, 0) mow, coalesce(d.mop, 0) mop, coalesce(d.kondom, 0) kondom, coalesce(d.implan, 0) implan, coalesce(d.suntik, 0) suntik, coalesce(d.pil, 0) pil,
		--non kontrasepsi
		coalesce(hamil, 0) hamil, coalesce(anak_segera, 0) anak_segera, coalesce(anak_kemudian, 0) anak_kemudian, coalesce(tidak_ingin_anak, 0) tidak_ingin_anak
	from new_kampung_kb a
	--target
	left join (
		select a.kampung_kb_id,
			sum(case when keluarga_id = 1 then jumlah else 0 end) pus,
			sum(case when keluarga_id = 2 then jumlah else 0 end) keluarga,
			sum(case when keluarga_id = 3 then jumlah else 0 end) remaja,
			sum(case when keluarga_id = 4 then jumlah else 0 end) memiliki_balita,
			sum(case when keluarga_id = 5 then jumlah else 0 end) memiliki_remaja,
			sum(case when keluarga_id = 6 then jumlah else 0 end) memiliki_lansia
		from new_penduduk_kampung a
		left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
		where is_active is true
		group by a.kampung_kb_id
	) b on a.id = b.kampung_kb_id
	--sasaran
	left join (
		select a.kampung_kb_id,
			sum(case when program_id = 1 then jumlah else 0 end) bkb,
			sum(case when program_id = 2 then jumlah else 0 end) bkr,
			sum(case when program_id = 3 then jumlah else 0 end) bkl,
			sum(case when program_id = 4 then jumlah else 0 end) uppka,
			sum(case when program_id = 5 then jumlah else 0 end) pikr
		from new_kkbpk_kampung a
		left join new_kkbpk_program b on a.id = b.kkbpk_kampung_id
		where is_active is true
		group by a.kampung_kb_id
	) c on a.id = c.kampung_kb_id
	left join (
		--KONTRASEPSI
		select c.kampung_kb_id,
			sum(case when kontrasepsi_id = 1 then jumlah else 0 end) iud,
			sum(case when kontrasepsi_id = 2 then jumlah else 0 end) mow,
			sum(case when kontrasepsi_id = 3 then jumlah else 0 end) mop,
			sum(case when kontrasepsi_id = 4 then jumlah else 0 end) kondom,
			sum(case when kontrasepsi_id = 5 then jumlah else 0 end) implan,
			sum(case when kontrasepsi_id = 6 then jumlah else 0 end) suntik,
			sum(case when kontrasepsi_id = 7 then jumlah else 0 end) pil
		from new_kkbpk_kontrasepsi a
		left join new_kontrasepsi b on a.kontrasepsi_id = b.id
		inner join (
			select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
			where 1=1 and x.is_active is true
			group by x.kampung_kb_id
		) c on a.kkbpk_kampung_id = c.id
		group by c.kampung_kb_id
	) d on a.id = d.kampung_kb_id
	left join (
		--NON KONTRASEPSI
		select c.kampung_kb_id,
			sum(case when non_kontrasepsi_id = 1 then jumlah else 0 end) hamil,
			sum(case when non_kontrasepsi_id = 2 then jumlah else 0 end) anak_segera,
			sum(case when non_kontrasepsi_id = 3 then jumlah else 0 end) anak_kemudian,
			sum(case when non_kontrasepsi_id = 4 then jumlah else 0 end) tidak_ingin_anak
		from new_kkbpk_non_kontrasepsi a
		left join new_non_kontrasepsi b on a.non_kontrasepsi_id = b.id
		inner join (
			select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
			where 1=1 and x.is_active is true
			group by x.kampung_kb_id
		) c on a.kkbpk_kampung_id = c.id
		group by c.kampung_kb_id
	) e on a.id = e.kampung_kb_id
	left join (
		select a.kampung_kb_id,
			sum(jumlah) penduduk
		from new_penduduk_kampung a
		left join new_penduduk_range b on a.id = b.penduduk_kampung_id
		where is_active is true
		group by a.kampung_kb_id
	) f on a.id = f.kampung_kb_id
	left join (
		select * from new_profil_kampung where is_active is true
	) g on a.id = g.kampung_kb_id
	left join (
		select a.kampung_kb_id, count(*) jumlah_operasional
		from new_profil_kampung a
		left join new_profil_operasional b on a.id = b.profil_id
		where a.is_active is true
		and operasional_flag is true
		group by a.kampung_kb_id
	) h on a.id = h.kampung_kb_id
	left join (
		select a.kampung_kb_id, count(*) jumlah_regulasi
		from new_profil_kampung a
		left join new_profil_regulasi b on a.id = b.profil_id
		where a.is_active is true
		group by a.kampung_kb_id
	) i on a.id = i.kampung_kb_id
	left join (
		select a.kampung_kb_id, count(*) jumlah_sumber_dana
		from new_profil_kampung a
		left join new_profil_sumber_dana b on a.id = b.profil_id
		where a.is_active is true
		group by a.kampung_kb_id
	) j on a.id = j.kampung_kb_id
	left join new_provinsi prov on a.provinsi_id = prov.id
	left join new_kabupaten kab on a.kabupaten_id = kab.id
	left join new_kecamatan kec on a.kecamatan_id = kec.id
	left join new_desa desa on a.desa_id = desa.id
	where a.is_active is true
	%1$s

) a