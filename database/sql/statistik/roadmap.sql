select id, nama,
			rw,
			case when(total_kkb > 0) then ROUND( ((rw/ total_kkb::float)*100)::decimal, 2 ) else 0 end rw_persen,
			dusun,
			case when(total_kkb > 0) then ROUND( ((dusun/ total_kkb::float)*100)::decimal, 2 ) else 0 end dusun_persen,
			desa,
			case when(total_kkb > 0) then ROUND( ((desa/ total_kkb::float)*100)::decimal, 2 ) else 0 end desa_persen,
			total_kkb
		from 
		(

			select a.id, a.nama, 
				sum(case when b.cakupan_wilayah = 'RW' then 1 else 0 end) rw,
				sum(case when b.cakupan_wilayah = 'Dusun' then 1 else 0 end) dusun,
				sum(case when b.cakupan_wilayah = 'Desa' then 1 else 0 end) desa,
				count(b.id_kkb) total_kkb 
			from  kampung_kb b
			left join provinsi a on b.id_provinsi = a.id
			group by a.id, a.nama

		) a
			order by a.nama