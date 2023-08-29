select a.id regional_id, a.name regional, b.*
from %1$s a
left join (

	select %2$s.id, %2$s.name,
		sum(Implan) implan,
		ROUND( ((sum(implan)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) implan_persen,
		sum(IUD) IUD,
		ROUND( ((sum(iud)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) iud_persen,
		sum(kondom) kondom,
		ROUND( ((sum(kondom)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) kondom_persen,
		sum(mop) mop,
		ROUND( ((sum(mop)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) mop_persen,
		sum(mow) mow,
		ROUND( ((sum(mow)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) mow_persen,
		sum(pil) pil,
		ROUND( ((sum(pil)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) pil_persen,
		sum(suntik) suntik,
		ROUND( ((sum(suntik)::float/ sum(total_kontrasepsi)::float)*100)::decimal, 2 ) suntik_persen,
		sum(case when b.kampung_kb_id is not null then 1 else 0 end) ada,
		sum(case when b.kampung_kb_id is null then 1 else 0 end) belum,
		sum(total_kontrasepsi) total_kontrasepsi,
		count(1) total,
		sum(pus) pus
	from new_kampung_kb a
	left join (

		select *, 
			case when (Implan is null and IUD is null and Kondom is null and MOP is null and MOW is null and PIL is null and Suntik is null) then null
				else COALESCE(Implan,0) + COALESCE(IUD,0) + COALESCE(Kondom,0) + COALESCE(MOP,0) + COALESCE(MOW,0) + COALESCE(PIL,0) + COALESCE(Suntik,0)
			end total_kontrasepsi
		from (
			select c.kampung_kb_id,
				sum(case when a.kontrasepsi_id = 1 then jumlah else 0 end) iud,
				sum(case when a.kontrasepsi_id = 2 then jumlah else 0 end) mow,
				sum(case when a.kontrasepsi_id = 3 then jumlah else 0 end) mop,
				sum(case when a.kontrasepsi_id = 4 then jumlah else 0 end) kondom,
				sum(case when a.kontrasepsi_id = 5 then jumlah else 0 end) implan,
				sum(case when a.kontrasepsi_id = 6 then jumlah else 0 end) suntik,
				sum(case when a.kontrasepsi_id = 7 then jumlah else 0 end) pil

			from new_kkbpk_kontrasepsi a
			left join new_kontrasepsi b on a.kontrasepsi_id = b.id
			inner join (
				select x.kampung_kb_id, max(id) id from new_kkbpk_kampung x
				where 1=1 %5$s
				group by x.kampung_kb_id
			) c on a.kkbpk_kampung_id = c.id
			group by c.kampung_kb_id
		) a


	) b on a.id = b.kampung_kb_id
	left join (
		select c.kampung_kb_id, b.id programs, jumlah pus
		from new_penduduk_keluarga a
		left join new_keluarga b on a.penduduk_kampung_id = b.id
		left join (
			select x.kampung_kb_id, max(id) id from new_penduduk_kampung x
			where 1=1 %5$s
			group by x.kampung_kb_id
		) c on a.penduduk_kampung_id = c.id
		where a.keluarga_id = 1 --pasangan usia subur
	) c on a.id = c.kampung_kb_id
	left join new_provinsi d on a.provinsi_id = d.id
	left join new_kabupaten e on a.kabupaten_id = e.id
	left join new_kecamatan f on a.kecamatan_id = f.id
	left join new_desa g on a.desa_id = g.id
	where 1=1 and a.is_active is true %3$s
	group by %2$s.id, %2$s.name
) b on a.id = b.id
%4$s
order by a.id

