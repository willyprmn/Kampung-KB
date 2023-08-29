		select *,
			case when klasifikasi = 'Dasar' then 1 else 0 end dasar,
			case when klasifikasi = 'Berkembang' then 1 else 0 end berkembang,
			case when klasifikasi = 'Mandiri' then 1 else 0 end mandiri,
			case when klasifikasi = 'Berkelanjutan' then 1 else 0 end berkelanjutan

		from (

			select *,
				case when (index_input < 3 and index_proses < 3 and index_output < 3) or
					(
						(case when index_input >= 3 then 1 else 0 end) +
						(case when index_proses >= 3 then 1 else 0 end) +
						(case when index_output >= 3 then 1 else 0 end)
					) = 1
					then 'Dasar'
					when (index_input >= 3 and index_proses >= 3) and index_output < 3 then 'Berkembang'
					when index_input >= 3 and index_proses >= 3 and index_output >= 3 then 'Berkelanjutan'
					when (index_input >= 3 or index_proses >= 3) and index_output >= 3 then 'Mandiri'
				end klasifikasi
			from (
				select a.id kampung_kb_id, a.nama, provinsi_id, kabupaten_id, kecamatan_id, desa_id,
					provinsi, kabupaten, kecamatan, desa,
					input_pokja, input_sumber_dana, input_poktan, input_sarana, input_pkb,
					proses_penggunaan_data, proses_operasional, proses_lintas_sektor,
					output_poktan, output_cpr, output_mkjp, output_unmet,
					ROUND( (input_pokja + input_sumber_dana + input_poktan + input_sarana + input_pkb) / 5::decimal,  2) index_input, -- 5 merupakan total indikator input
					ROUND( (proses_penggunaan_data + proses_operasional + proses_lintas_sektor) / 3::decimal, 2) index_proses, -- 3 merupakan total indikator proses
					ROUND( (output_poktan + output_cpr + output_mkjp + output_unmet) / 4::decimal, 2) index_output -- 4 merupakan total indikator output
				from (
					--variable input
					select a.id, a.nama, provinsi_id, kabupaten_id, kecamatan_id, desa_id,
						l.name provinsi, m.name kabupaten, n.name kecamatan, o.name desa,
						case when b.pokja_pengurusan_flag is null or b.pokja_pengurusan_flag is false then 1
							when b.pokja_pengurusan_flag is true and b.pokja_jumlah > 0 and pokja_pelatihan_flag is true then 4
							when b.pokja_pengurusan_flag is true and (b.pokja_jumlah > 0 or pokja_pelatihan_flag is true) then 3
							when b.pokja_pengurusan_flag is true then 2
						end input_pokja,

						case when coalesce(c.total_sumber_dana,0) = 0 then 1
							when coalesce(c.total_sumber_dana,0) = 1 then 2
							when coalesce(c.total_sumber_dana,0) between 2 and 4 then 3
							when coalesce(c.total_sumber_dana,0) > 4 then 4
						end input_sumber_dana,

						case when coalesce(d.total_poktan,0) = 0 then 1
							when coalesce(d.total_poktan,0) between 1 and 2 then 2
							when coalesce(d.total_poktan,0) between 3 and 4 then 3
							when coalesce(d.total_poktan,0) > 4 then 4
						end input_poktan,

						case when coalesce(e.total_sarana,0) = 0 then 1
							when coalesce(e.total_sarana,0) = 1 then 2
							when coalesce(e.total_sarana,0) = 2 then 3
						end input_sarana,

						case when coalesce(b.plkb_pendamping_flag, false) is false and coalesce(b.regulasi_flag, false) is false then 1
							when b.plkb_pendamping_flag is true and b.regulasi_flag is true then 3
							when b.plkb_pendamping_flag is true or b.regulasi_flag is true then 2
						end input_pkb,

						--varible proses
						case when coalesce(f.total_penggunaan_data,0) = 0 then 1
							when coalesce(f.total_penggunaan_data,0) = 1 then 2
							when coalesce(f.total_penggunaan_data,0) between 2 and 3 then 3
							when coalesce(f.total_penggunaan_data,0) > 3 then 4
						end proses_penggunaan_data,

						case when coalesce(g.total_operasional,0) = 0 then 1
							when coalesce(g.total_operasional,0) between 1 and 2 then 2
							when coalesce(g.total_operasional,0) between 3 and 4 then 3
							when coalesce(g.total_operasional,0) > 4 then 4
						end proses_operasional,

						case when coalesce(h.total_lintas_sektor,0) = 0 then 1
							when coalesce(h.total_lintas_sektor,0) between 1 and 3 then 2
							when coalesce(h.total_lintas_sektor,0) between 4 and 6 then 3
							when coalesce(h.total_lintas_sektor,0) > 6 then 4
						end proses_lintas_sektor,

						--variable output
						i.output_persentase_poktan,
						case when coalesce(i.output_persentase_poktan, 0) < 10 then 1
							when coalesce(i.output_persentase_poktan, 0) between 10 and 20 then 2
							when coalesce(i.output_persentase_poktan, 0) between 21 and 30 then 3
							when coalesce(i.output_persentase_poktan, 0) > 30 then 4
						end output_poktan,

						case when j.output_persentase_cpr is null then 1 
							when coalesce(j.output_persentase_cpr, 0) < 30 then 1
							when coalesce(j.output_persentase_cpr, 0) between 30 and 40 then 2
							when coalesce(j.output_persentase_cpr, 0) between 41 and 50 then 3
							when coalesce(j.output_persentase_cpr, 0) > 50 then 4
						end output_cpr,

						case when j.output_persentase_mkjp is null then 1 
							when coalesce(j.output_persentase_mkjp, 0) < 20 then 1
							when coalesce(j.output_persentase_mkjp, 0) between 20 and 22 then 2
							when coalesce(j.output_persentase_mkjp, 0) between 23 and 24 then 3
							when coalesce(j.output_persentase_mkjp, 0) > 24 then 4
						end output_mkjp,

						case when k.output_persentase_unmet is null then 1 
							when coalesce(k.output_persentase_unmet, 0) > 12.1 then 1
							when coalesce(k.output_persentase_unmet, 0) between 9.1 and 12 then 2
							when coalesce(k.output_persentase_unmet, 0) between 6.1 and 9 then 3
							when coalesce(k.output_persentase_unmet, 0) < 6.1 then 4
						end output_unmet
					from new_kampung_kb a
					left join (
						select * from new_profil_kampung where is_active is true %5$s
					) b on a.id = b.kampung_kb_id
					left join (select profil_id, count(1) total_sumber_dana from new_profil_sumber_dana group by profil_id) c on b.id = c.profil_id
					left join (
						select profil_id, count(1) total_poktan from new_profil_program
						where program_flag is true and program_id not in (6, 7)
						group by profil_id
					) d on b.id = d.profil_id
					left join (
						select profil_id, count(1) total_sarana from new_profil_program
						where program_flag is true and program_id in (6, 7)
						group by profil_id
					) e on b.id = e.profil_id
					--variable proses
					left join (
						select profil_id, count(1) total_penggunaan_data from new_profil_penggunaan_data
						group by profil_id
					) f on b.id = f.profil_id
					left join (
						select profil_id, count(1) total_operasional from new_profil_operasional
						where operasional_flag is true
						group by profil_id
					) g on b.id = g.profil_id
					left join (
						select kampung_kb_id, count(distinct instansi_id) total_lintas_sektor from new_intervensi a
						left join new_intervensi_instansi b on a.id = intervensi_id
						where b.intervensi_id not in (26, 34)
						group by kampung_kb_id
					) h on a.id = h.kampung_kb_id

					--variable output
					left join (
						select kampung_kb_id,
							round(sum(persentase) / 5) output_persentase_poktan
						from (
							select a.kampung_kb_id,
								case when jumlah_penduduk > 0 then ROUND( ((jumlah_program / jumlah_penduduk::float)*100) ) else 0 end persentase
							from (
								select kampung_kb_id, keluarga_id, c.alias keluarga_name, coalesce(jumlah, 0) jumlah_penduduk,
									case when keluarga_id = 4 then 1
										when keluarga_id = 5 then 2
										when keluarga_id = 6 then 3
										when keluarga_id = 2 then 4
										when keluarga_id = 3 then 5
									end program_map_id
								from new_penduduk_kampung a
								left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
								left join new_keluarga c on b.keluarga_id = c.id
								where 1=1 %5$s
								and keluarga_id between 2 and 6
							) a
							left join (
								select a.kampung_kb_id, b.program_id, c.name program_name, coalesce(jumlah, 0) jumlah_program
								from new_kkbpk_kampung a
								left join new_kkbpk_program b on a.id = b.kkbpk_kampung_id
								left join new_program c on b.program_id = c.id
								where  1=1 %5$s
							) b on a.kampung_kb_id = b.kampung_kb_id and a.program_map_id = b.program_id
							order by program_map_id
						) a
						group by kampung_kb_id
					) i on a.id = i.kampung_kb_id

					left join (


						select a.kampung_kb_id,
							case when jumlah_pus > 0 then ROUND( ((jumlah_kontrasepsi / jumlah_pus::float)*100) ) else 0 end output_persentase_cpr,
							case when jumlah_kontrasepsi > 0 then ROUND( ((jumlah_mkjp / jumlah_kontrasepsi::float)*100) ) else 0 end output_persentase_mkjp
						from (
							select kampung_kb_id, keluarga_id, c.alias keluarga_name, coalesce(jumlah, 0) jumlah_pus
							from new_penduduk_kampung a
							left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
							left join new_keluarga c on b.keluarga_id = c.id
							where  1=1 %5$s
							and keluarga_id = 1 --get only pus

						) a
						left join (

							select a.kampung_kb_id,  coalesce(sum(jumlah), 0) jumlah_kontrasepsi
							from new_kkbpk_kampung a
							left join new_kkbpk_kontrasepsi b on a.id = b.kkbpk_kampung_id
							left join new_kontrasepsi c on b.kontrasepsi_id = c.id
							where  1=1 %5$s
							group by a.kampung_kb_id

						) b on a.kampung_kb_id = b.kampung_kb_id
						left join (

							select a.kampung_kb_id,  coalesce(sum(jumlah), 0) jumlah_mkjp
							from new_kkbpk_kampung a
							left join new_kkbpk_kontrasepsi b on a.id = b.kkbpk_kampung_id
							left join new_kontrasepsi c on b.kontrasepsi_id = c.id
							where  1=1 %5$s
							and c.id in (1,2,3, 5) --get only MOW, MOP, IUD, IMPLAN
							group by a.kampung_kb_id

						) c on a.kampung_kb_id = c.kampung_kb_id

					) j on a.id = j.kampung_kb_id

					left join (
						select a.kampung_kb_id,
							case when jumlah_unmet_need > 0 then ROUND( ((jumlah_non_kontrasepsi / jumlah_unmet_need::float)*100)) else 0 end output_persentase_unmet
						from (

							select a.kampung_kb_id, coalesce(sum(jumlah), 0) jumlah_non_kontrasepsi
							from new_kkbpk_kampung a
							left join new_kkbpk_non_kontrasepsi b on a.id = b.kkbpk_kampung_id
							left join new_non_kontrasepsi c on b.non_kontrasepsi_id = c.id
							where  1=1 %5$s
							and c.id in (3,4) --get only IAT, TIAL
							group by a.kampung_kb_id

						) a
						left join (

							select kampung_kb_id, keluarga_id, coalesce(jumlah, 0) jumlah_unmet_need
							from new_penduduk_kampung a
							left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
							left join new_keluarga c on b.keluarga_id = c.id
							where  1=1 %5$s
							and keluarga_id = 1 --get only pus

						) b on a.kampung_kb_id = b.kampung_kb_id
					) k on a.id = k.kampung_kb_id

					left join new_provinsi l on a.provinsi_id = l.id
					left join new_kabupaten m on a.kabupaten_id = m.id
					left join new_kecamatan n on a.kecamatan_id = n.id
					left join new_desa o on a.desa_id = o.id

					where a.is_active is true
					%3$s
				) a
			)a
		) a
