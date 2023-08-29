select a.id, a.name regional, b.*
from %1$s a
left join(
	select *,
		mengisi - (kegiatan_1 + kegiatan_2 + kegiatan_3) tidak_isi
	from
	(
		select a.*,
			(kegiatan_1 + kegiatan_2 + kegiatan_3 + tidak_kategori) - belum_isi mengisi,
			(kegiatan_1 + kegiatan_2 + kegiatan_3 + tidak_kategori) total
		from (
			select regional_id,
				sum(keagamaan) keagamaan,
				sum(pendidikan) pendidikan,
				sum(reproduksi) reproduksi,
				sum(ekonomi) ekonomi,
				sum(perlindungan) perlindungan,
				sum(kasih_sayang) kasih_sayang,
				sum(sosial_budaya) sosial_budaya,
				sum(pembinaan_lingkungan) pembinaan_lingkungan,
				sum(pembinaan_lingkungan) lainnya,

				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 1 and 3 then 1 else 0 end) kegiatan_1,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 4 and 6 then 1 else 0 end) kegiatan_2,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 7 and 9 then 1 else 0 end) kegiatan_3,
				sum(tidak_kategori) tidak_kategori,
				sum(belum_isi) belum_isi
			from (
				select b.kampung_kb_id, %2$s.id regional_id ,
					sum(case when c.id = 1 then 1 else 0 end) keagamaan,
					sum(case when c.id = 2 then 1 else 0 end) pendidikan,
					sum(case when c.id = 3 then 1 else 0 end) reproduksi,
					sum(case when c.id = 4 then 1 else 0 end) ekonomi,
					sum(case when c.id = 5 then 1 else 0 end) perlindungan,
					sum(case when c.id = 6 then 1 else 0 end) kasih_sayang,
					sum(case when c.id = 7 then 1 else 0 end) sosial_budaya,
					sum(case when c.id = 8 then 1 else 0 end) pembinaan_lingkungan,
					sum(case when c.id = 9 then 1 else 0 end) lainnya,
					count(*) jumlah_kegiatan,
					sum(case when bb.kampung_kb_id is null then 1 else 0 end) belum_isi,
					sum(case when b.kampung_kb_id is null then 1 else 0 end) tidak_kategori --jumlah ini termasuk belum isi dan tidak dalam kategori IN
				from new_kampung_kb a
				left join (
					select distinct kategori_id, kampung_kb_id from new_kampung_kb a
					left join new_intervensi b on a.id = b.kampung_kb_id
					where a.is_active is true
                    %5$s
				) b on a.id = b.kampung_kb_id
				left join (
					select distinct kampung_kb_id from new_intervensi b
                    where 1=1 %5$s
				) bb on a.id = bb.kampung_kb_id
				left join new_kategori c on b.kategori_id = c.id
				left join new_provinsi d on a.provinsi_id = d.id
				left join new_kabupaten e on a.kabupaten_id = e.id
				left join new_kecamatan f on a.kecamatan_id = f.id
				left join new_desa g on a.desa_id = g.id
				where is_active is true %3$s
				group by %2$s.id, b.kampung_kb_id
			) a
			group by regional_id
		) a
	) a
) b on a.id = b.regional_id
%4$s
order by a.id

