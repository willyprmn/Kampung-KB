--=================================================================================
--BACKUP DATA
--=================================================================================

drop table if exists new_kkbpk_program_bak;
drop table if exists new_penduduk_keluarga_bak;
drop table if exists new_kkbpk_non_kontrasepsi_bak;

select * into new_kkbpk_program_bak from new_kkbpk_program;

select * into new_penduduk_keluarga_bak from new_penduduk_keluarga;

select * into new_kkbpk_non_kontrasepsi_bak from new_kkbpk_non_kontrasepsi;


--=================================================================================
--ITERASI 1
--=================================================================================

update new_kkbpk_non_kontrasepsi x
set jumlah = case when x.non_kontrasepsi_id = 1 then val_karena_hamil when x.non_kontrasepsi_id = 2 then val_anak_segera else x.jumlah end --update only karena hamil and ingin anak segera
from new_kkbpk_kampung a
inner join (
	select *, mod(unmet_need, 2) modulus,
		case when unmet_need > 0 then unmet_need/2 else 0 end val_karena_hamil,
		case when unmet_need > 0 then 
			case when mod(unmet_need, 2) = 1 then (unmet_need/2) + 1
				when mod(unmet_need, 2) = 0 then unmet_need/2
			end
		end val_anak_segera
	from (
		select *,
			case when (total_kkbpk = total_pus) then 0 else total_pus - (total_kontrasepsi + total_iat_tial) end unmet_need
		from 
		(
			select a.kampung_kb_id,
				total_pus,
				total_kontrasepsi,
				total_non_kontrasepsi,
				total_iat_tial,
				(total_kontrasepsi + total_iat_tial) total_kb_tial,
				(total_kontrasepsi + total_non_kontrasepsi) total_kkbpk
			from (
				--CPR
				select c.kampung_kb_id,
					sum(jumlah) total_kontrasepsi
				from new_kkbpk_kontrasepsi a
				left join new_kontrasepsi b on a.kontrasepsi_id = b.id
				inner join (
					select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
					where 1=1 and x.is_active is true
					group by x.kampung_kb_id
				) c on a.kkbpk_kampung_id = c.id
				group by c.kampung_kb_id
			) a
			left join (
				--PUS
				select kampung_kb_id, keluarga_id, coalesce(jumlah, 0) total_pus
				from new_penduduk_kampung a
				left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
				left join new_keluarga c on b.keluarga_id = c.id
				where is_active is true
				and keluarga_id = 1 --get only pus
			) b on a.kampung_kb_id = b.kampung_kb_id
			left join (
				--IAT & TIAL
				select c.kampung_kb_id,
					sum(jumlah) total_iat_tial
				from new_kkbpk_non_kontrasepsi a
				left join new_non_kontrasepsi b on a.non_kontrasepsi_id = b.id
				inner join (
					select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
					where 1=1 and x.is_active is true
					group by x.kampung_kb_id
				) c on a.kkbpk_kampung_id = c.id
				where b.id in(3,4) --get IAT TIAL
				group by c.kampung_kb_id
			) c on a.kampung_kb_id = c.kampung_kb_id
			left join (
				--TIDAK BER KB
				select c.kampung_kb_id,
					sum(jumlah) total_non_kontrasepsi
				from new_kkbpk_non_kontrasepsi a
				left join new_non_kontrasepsi b on a.non_kontrasepsi_id = b.id
				inner join (
					select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
					where 1=1 and x.is_active is true
					group by x.kampung_kb_id
				) c on a.kkbpk_kampung_id = c.id
				group by c.kampung_kb_id
			) d on a.kampung_kb_id = d.kampung_kb_id
		) a
	) a
	where total_kb_tial < total_pus and unmet_need >= 0 and total_pus != total_kkbpk and total_kkbpk > 0

) b on a.kampung_kb_id = b.kampung_kb_id
inner join new_kkbpk_non_kontrasepsi c on a.id = c.kkbpk_kampung_id
where a.is_active is true
--and a.kampung_kb_id = 1106
and x.kkbpk_kampung_id = c.kkbpk_kampung_id
and x.non_kontrasepsi_id in (1,2);


--=================================================================================
--ITERASI 2
--=================================================================================

update new_penduduk_keluarga x
set jumlah = case when x.keluarga_id = 1 then total_kkbpk else x.jumlah end --update only PUS
from new_penduduk_kampung a
inner join (
	select *, mod(unmet_need, 2) modulus,
		case when unmet_need > 0 then unmet_need/2 else 0 end val_karena_hamil,
		case when unmet_need > 0 then 
			case when mod(unmet_need, 2) = 1 then (unmet_need/2) + 1
				when mod(unmet_need, 2) = 0 then unmet_need/2
			end
		end val_anak_segera
	from (
		select *,
			case when (total_kkbpk = total_pus) then 0 else total_pus - (total_kontrasepsi + total_iat_tial) end unmet_need
		from 
		(
			select a.kampung_kb_id,
				total_pus,
				total_kontrasepsi,
				total_non_kontrasepsi,
				total_iat_tial,
				(total_kontrasepsi + total_iat_tial) total_kb_tial,
				(total_kontrasepsi + total_non_kontrasepsi) total_kkbpk
			from (
				--CPR
				select c.kampung_kb_id,
					sum(jumlah) total_kontrasepsi
				from new_kkbpk_kontrasepsi a
				left join new_kontrasepsi b on a.kontrasepsi_id = b.id
				inner join (
					select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
					where 1=1 and x.is_active is true
					group by x.kampung_kb_id
				) c on a.kkbpk_kampung_id = c.id
				group by c.kampung_kb_id
			) a
			left join (
				--PUS
				select kampung_kb_id, keluarga_id, coalesce(jumlah, 0) total_pus
				from new_penduduk_kampung a
				left join new_penduduk_keluarga b on a.id = b.penduduk_kampung_id
				left join new_keluarga c on b.keluarga_id = c.id
				where is_active is true
				and keluarga_id = 1 --get only pus
			) b on a.kampung_kb_id = b.kampung_kb_id
			left join (
				--IAT & TIAL
				select c.kampung_kb_id,
					sum(jumlah) total_iat_tial
				from new_kkbpk_non_kontrasepsi a
				left join new_non_kontrasepsi b on a.non_kontrasepsi_id = b.id
				inner join (
					select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
					where 1=1 and x.is_active is true
					group by x.kampung_kb_id
				) c on a.kkbpk_kampung_id = c.id
				where b.id in(3,4) --get IAT TIAL
				group by c.kampung_kb_id
			) c on a.kampung_kb_id = c.kampung_kb_id
			left join (
				--TIDAK BER KB
				select c.kampung_kb_id,
					sum(jumlah) total_non_kontrasepsi
				from new_kkbpk_non_kontrasepsi a
				left join new_non_kontrasepsi b on a.non_kontrasepsi_id = b.id
				inner join (
					select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
					where 1=1 and x.is_active is true
					group by x.kampung_kb_id
				) c on a.kkbpk_kampung_id = c.id
				group by c.kampung_kb_id
			) d on a.kampung_kb_id = d.kampung_kb_id
		) a
	) a
	where total_kkbpk > total_pus

) b on a.kampung_kb_id = b.kampung_kb_id
inner join new_penduduk_keluarga c on a.id = c.penduduk_kampung_id
where a.is_active is true
--and a.kampung_kb_id = 1103
and x.penduduk_kampung_id = c.penduduk_kampung_id
and x.keluarga_id = 1;