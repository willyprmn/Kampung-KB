select a.id, a.name regional, v.*, b.belum_isi, instansi_1, instansi_2, instansi_3, b.total total_kampung
from %1$s a
left join ct_view v on a.id = v.regional_id
left join (
    select *, (belum_isi + instansi_1 + instansi_2 + instansi_3) total

    from (

        select regional_id,
            sum(belum_isi) belum_isi,
            sum(case when jumlah_instansi = 1 then 1 else 0 end) instansi_1,
            sum(case when jumlah_instansi between 2 and 4 then 1 else 0 end) instansi_2,
            sum(case when jumlah_instansi > 4 then 1 else 0 end) instansi_3
        from (
            select b.kampung_kb_id, %2$s.id regional_id ,
                count(b.kampung_kb_id) jumlah_instansi
                ,sum(case when b.kampung_kb_id is null then 1 else 0 end) belum_isi
            from new_kampung_kb a
            left join (
				select distinct b.kampung_kb_id, c.instansi_id
				from new_kampung_kb a
				left join new_intervensi b on a.id = b.kampung_kb_id
				inner join new_intervensi_instansi c on b.id = c.intervensi_id
                where 1=1 %5$s
			) b on a.id = b.kampung_kb_id 
            left join new_instansi d on b.instansi_id = d.id
            left join new_provinsi e on a.provinsi_id = e.id
            left join new_kabupaten f on a.kabupaten_id = f.id
            left join new_kecamatan g on a.kecamatan_id = g.id
            left join new_desa h on a.desa_id = h.id
            where a.is_active is true %3$s
            group by %2$s.id, b.kampung_kb_id
        ) a
        group by regional_id

    ) a
) b on v.regional_id = b.regional_id
%4$s
order by v.regional_id