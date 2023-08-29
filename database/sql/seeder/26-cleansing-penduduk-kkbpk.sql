--ITERATION #1
--UPDATE DATA KKBPK PROGRAM YANG TIDAK LEBIH BESAR DARI DATA KEPENDUDUKAN
update new_kkbpk_program x
set jumlah = case when x.program_id = 1 and a.bkb_mapping is false then a.memiliki_balita  
				when x.program_id = 2 and a.bkr_mapping is false then a.memiliki_remaja 
				when x.program_id = 3 and a.bkl_mapping is false then a.memiliki_lansia 
				when x.program_id = 4 and a.uppka_mapping is false then a.keluarga 
				when x.program_id = 5 and a.pikr_mapping is false then a.remaja 
			else x.jumlah
		end
--select *
from (
	select * 
	from (
		select a.id, a.nama,
			--mapping kolom
			case when coalesce(bkb, 0) > coalesce(memiliki_balita, 0) then false else true end bkb_mapping, 
			case when coalesce(bkr, 0) > coalesce(memiliki_remaja, 0) then false else true end bkr_mapping, 
			case when coalesce(bkl, 0) > coalesce(memiliki_lansia, 0) then false else true end bkl_mapping, 
			case when coalesce(uppka, 0) > coalesce(keluarga, 0) then false else true end uppka_mapping, 
			case when coalesce(pikr, 0) > coalesce(remaja, 0) then false else true end pikr_mapping, 
		
			--flaging penduduk bernilai 0
			case when coalesce(keluarga, 0) = 0 or coalesce(remaja, 0) = 0 or coalesce(memiliki_balita, 0) = 0 
				or coalesce(memiliki_remaja, 0) = 0 or coalesce(memiliki_lansia, 0) = 0 then true
				else false
			end is_empty_penduduk,
		
			b.keluarga, b.remaja, b.memiliki_balita, b.memiliki_remaja, b.memiliki_lansia,
			c.bkb, c.bkr, c.bkl, c.uppka, c.pikr
		from new_kampung_kb a
		--target
		left join (
			select a.kampung_kb_id,
				sum(case when keluarga_id = 2 then jumlah else 0 end) keluarga,
				sum(case when keluarga_id = 3 then jumlah else 0 end) remaja,
				sum(case when keluarga_id = 4 then jumlah else 0 end) memiliki_balita,
				sum(case when keluarga_id = 5 then jumlah else 0 end) memiliki_remaja,
				sum(case when keluarga_id = 6 then jumlah else 0 end) memiliki_lansia
			from new_penduduk_kampung a
			left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
			where is_active is true
			and b.keluarga_id != 1
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
		where a.is_active is true 	
		and c.kampung_kb_id is not null
	) a
	--show only consist false mapping 
	where bkb_mapping is false or bkr_mapping is false or bkl_mapping is false or uppka_mapping is false or pikr_mapping is false
) a
inner join new_kkbpk_kampung b on a.id = b.kampung_kb_id
inner join new_kkbpk_program c on b.id = c.kkbpk_kampung_id
where b.is_active is true
and is_empty_penduduk is false --ambil data yg penduduk tidak ada nilai 0 untuk di update pada table kkbpk_program
and x.kkbpk_kampung_id = c.kkbpk_kampung_id;


--ITERATION #2
--UPDATE DATA KKBPK PROGRAM YANG MEMILIKI NILAI LEBIH DARI 0, SEDANGKAN KEPENDUDUKAN BERNILAI 0
update new_kkbpk_program x
set jumlah = case when x.program_id = 1 and a.memiliki_balita = 0 and a.bkb > 0 then 0 
				when x.program_id = 2 and a.memiliki_remaja = 0 and a.bkr > 0 then 0
				when x.program_id = 3 and a.memiliki_lansia = 0 and a.bkl > 0 then 0
				when x.program_id = 4 and a.keluarga = 0 and a.uppka > 0 then 0 
				when x.program_id = 5 and a.remaja = 0 and a.pikr > 0 then 0 
			else x.jumlah
		end
--select *
from (
	select * 
	from (
		select a.id, a.nama,
			--mapping kolom
			case when coalesce(bkb, 0) > coalesce(memiliki_balita, 0) then false else true end bkb_mapping, 
			case when coalesce(bkr, 0) > coalesce(memiliki_remaja, 0) then false else true end bkr_mapping, 
			case when coalesce(bkl, 0) > coalesce(memiliki_lansia, 0) then false else true end bkl_mapping, 
			case when coalesce(uppka, 0) > coalesce(keluarga, 0) then false else true end uppka_mapping, 
			case when coalesce(pikr, 0) > coalesce(remaja, 0) then false else true end pikr_mapping, 
		
			--flaging penduduk bernilai 0
			case when coalesce(keluarga, 0) = 0 or coalesce(remaja, 0) = 0 or coalesce(memiliki_balita, 0) = 0 
				or coalesce(memiliki_remaja, 0) = 0 or coalesce(memiliki_lansia, 0) = 0 then true
				else false
			end is_empty_penduduk,
		
			b.keluarga, b.remaja, b.memiliki_balita, b.memiliki_remaja, b.memiliki_lansia,
			c.bkb, c.bkr, c.bkl, c.uppka, c.pikr
		from new_kampung_kb a
		--target
		left join (
			select a.kampung_kb_id,
				sum(case when keluarga_id = 2 then jumlah else 0 end) keluarga,
				sum(case when keluarga_id = 3 then jumlah else 0 end) remaja,
				sum(case when keluarga_id = 4 then jumlah else 0 end) memiliki_balita,
				sum(case when keluarga_id = 5 then jumlah else 0 end) memiliki_remaja,
				sum(case when keluarga_id = 6 then jumlah else 0 end) memiliki_lansia
			from new_penduduk_kampung a
			left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
			where is_active is true
			and b.keluarga_id != 1
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
		where a.is_active is true 	
		and c.kampung_kb_id is not null
	) a
	--show only consist false mapping 
	where is_empty_penduduk is true
	--and id = 1118
	
) a
inner join new_kkbpk_kampung b on a.id = b.kampung_kb_id
inner join new_kkbpk_program c on b.id = c.kkbpk_kampung_id
where b.is_active is true
and x.kkbpk_kampung_id = c.kkbpk_kampung_id;
