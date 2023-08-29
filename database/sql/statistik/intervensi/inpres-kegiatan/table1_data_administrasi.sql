select a.id, a.name regional, b.*
from %1$s a
left join(
	select *,
		mengisi - (kegiatan_1 + kegiatan_2) tidak_isi
	from
	(
		select a.*,
			--untuk mendapatkan jumlah yang sudah mengisi lakukan penjumlahan untuk kegiatan + tidak kegiatan dikurang belum mengisi
			(kegiatan_1 + kegiatan_2 + tidak_kategori) - belum_isi mengisi,
			--untuk mendapatkan total kampung, jumlahkan yg melakukan kegiatan dengan tidak berkategori
			(kegiatan_1 + kegiatan_2 + tidak_kategori) total
		from (
			select regional_id,
				sum(rumah_dataku) rumah_dataku,
				sum(administrasi) administrasi,
				sum(case when (rumah_dataku > 0 and administrasi = 0) or (rumah_dataku = 0 and administrasi > 0) then 1 else 0 end) kegiatan_1,
				sum(case when rumah_dataku > 0 and administrasi > 0 then 1 else 0 end) kegiatan_2,
				sum(tidak_kategori) tidak_kategori,
				sum(belum_isi) belum_isi
			from (
				select b.kampung_kb_id, %2$s.id regional_id ,
					sum(case when c.id = 1 then 1 else 0 end) rumah_dataku,
					sum(case when c.id = 2 then 1 else 0 end) administrasi,
					sum(case when bb.kampung_kb_id is null then 1
						else 0 --karena row intervensi dapat memiliki 1 dan 2 kode kegiatan, maka aggregate count akan berjumlah 2, sehingga perlu di set menjadi 0
						end) belum_isi,
					sum(case when b.kampung_kb_id is null then 1 else 0 end) tidak_kategori --jumlah ini termasuk belum isi dan tidak dalam kategori IN
				from new_kampung_kb a
				left join (
					select distinct inpres_kegiatan_id, kampung_kb_id 
					from new_kampung_kb a
					left join new_intervensi b on a.id = b.kampung_kb_id
					left join new_inpres_kegiatans c on b.inpres_kegiatan_id = c.id
					left join new_inpres_programs d on c.inpres_program_id = d.id
					where d.id = 1 --program 1
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

