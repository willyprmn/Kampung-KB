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
				sum(program_pus) program_pus,
				sum(aset_kpm) aset_kpm,
				sum(kesejahteraan_kpm) kesejahteraan_kpm,
				sum(bantuan_permodalan) bantuan_permodalan,
				sum(pemasaran_koperasi) pemasaran_koperasi,
				sum(pelatihan_produksi) pelatihan_produksi,
				sum(kb_berkualitas) kb_berkualitas,
				sum(kemandirian_ekonomi) kemandirian_ekonomi,
				sum(usaha_nelayan) usaha_nelayan,
				sum(sistem_pembenihan) sistem_pembenihan,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 1 and 4 then 1 else 0 end) kegiatan_1,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 5 and 7 then 1 else 0 end) kegiatan_2,
				sum(case when kampung_kb_id is not null and jumlah_kegiatan between 8 and 10 then 1 else 0 end) kegiatan_3,
				sum(tidak_kategori) tidak_kategori,
				sum(belum_isi) belum_isi
			from (
				select b.kampung_kb_id, %2$s.id regional_id ,
					sum(case when c.id = 46 then 1 else 0 end) program_pus,
					sum(case when c.id = 47 then 1 else 0 end) aset_kpm,
					sum(case when c.id = 48 then 1 else 0 end) kesejahteraan_kpm,
					sum(case when c.id = 49 then 1 else 0 end) bantuan_permodalan,
					sum(case when c.id = 50 then 1 else 0 end) pemasaran_koperasi,
					sum(case when c.id = 51 then 1 else 0 end) pelatihan_produksi,
					sum(case when c.id = 52 then 1 else 0 end) kb_berkualitas,
					sum(case when c.id = 53 then 1 else 0 end) kemandirian_ekonomi,
					sum(case when c.id = 54 then 1 else 0 end) usaha_nelayan,
					sum(case when c.id = 55 then 1 else 0 end) sistem_pembenihan,
					count(*) jumlah_kegiatan,
					sum(case when bb.kampung_kb_id is null then 1 else 0 end) belum_isi,
					sum(case when b.kampung_kb_id is null then 1 else 0 end) tidak_kategori --jumlah ini termasuk belum isi dan tidak dalam kategori IN
				from new_kampung_kb a
				left join (
					select distinct inpres_kegiatan_id, kampung_kb_id 
					from new_kampung_kb a
					left join new_intervensi b on a.id = b.kampung_kb_id
					left join new_inpres_kegiatans c on b.inpres_kegiatan_id = c.id
					left join new_inpres_programs d on c.inpres_program_id = d.id
					where d.id = 7 --program 7
					and a.is_active is true 
					%5$s
				) b on a.id = b.kampung_kb_id
				left join (
					select distinct kampung_kb_id from new_intervensi
					%5$s
				) bb on a.id = bb.kampung_kb_id
				left join new_inpres_kegiatans c on b.inpres_kegiatan_id = c.id
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

