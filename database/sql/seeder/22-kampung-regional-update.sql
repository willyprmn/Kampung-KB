--kampung null regional update
drop table if exists new_kampung_regional_update;
create table new_kampung_regional_update(
	id serial,
	kampung_kb_id integer,
	nama text,
	tanggal_pencanangan text,
	KEAKTIFAN text,
	provinsi_id text,
	provinsi text,
	kabupaten_id text,
	kabupaten text,
	kecamatan_id text,
	kecamatan text,
	desa_id text,
	desa text,
	created_by text,
	username text,
	jumlah_intervensi integer,
	intervensi_aktif boolean,
	jumlah_profil integer,
	profil_aktif boolean,
	jumlah_penduduk integer,
	penduduk_aktif boolean,
	jumlah_kkbpk integer,
	kkbpk_aktif boolean,
	is_active boolean,
	status_aktifitas boolean,
	check_data text,
	Keterangan text,
	status text,
	status_ket text
);

COPY new_kampung_regional_update(
	kampung_kb_id, nama, tanggal_pencanangan, KEAKTIFAN, provinsi_id, provinsi, kabupaten_id, kabupaten,
	kecamatan_id, kecamatan, desa_id, desa, created_by, username,
	jumlah_intervensi, intervensi_aktif, jumlah_profil, profil_aktif, jumlah_penduduk, penduduk_aktif,
	jumlah_kkbpk, kkbpk_aktif, is_active, status_aktifitas, check_data, Keterangan, status, status_ket
)
FROM 'path_file_regional_null_update'
DELIMITER ','
CSV HEADER
encoding 'windows-1251';

--REGIONAL NOT MATCH
drop table if exists new_kampung_regional_not_match_update;
create table new_kampung_regional_not_match_update(
	id serial,
	kampung_kb_id integer,
	nama_kampung text,
	provinsi text,
	provinsi_id text,
	kabupaten text,
	kabupaten_id text,
	kecamatan text,
	kecamatan_id text,
	desa text,
	desa_id text,
	status_check text,
	siga_provinsi_id text,
	siga_provinsi_nama text,
	siga_kabupaten_id text,
	siga_kabupaten_nama text,
	siga_kecamatan_id text,
	siga_kecamatan_nama text,
	siga_keluarahan_id text,
	siga_kelurahan_nama text
);

COPY new_kampung_regional_not_match_update(
	kampung_kb_id, nama_kampung, provinsi, provinsi_id, kabupaten, kabupaten_id, kecamatan,
	kecamatan_id, desa, desa_id, status_check, siga_provinsi_id, siga_provinsi_nama,
	siga_kabupaten_id, siga_kabupaten_nama, siga_kecamatan_id, siga_kecamatan_nama,
	siga_keluarahan_id, siga_kelurahan_nama
)
FROM 'path_file_regional_siga_update'
DELIMITER ','
CSV HEADER
encoding 'windows-1251';


--update kampung yang tidak status hapus
update new_kampung_kb a
set provinsi_id = lpad(b.provinsi_id, 2, '00') ,
	kabupaten_id = lpad(b.provinsi_id, 2, '00') || lpad(b.kabupaten_id, 2, '00'),
	kecamatan_id = lpad(b.provinsi_id, 2, '00') || lpad(b.kabupaten_id, 2, '00') || lpad(b.kecamatan_id, 2, '00'),
	desa_id = lpad(b.provinsi_id, 2, '00') || lpad(b.kabupaten_id, 2, '00') || lpad(b.kecamatan_id, 2, '00')|| lpad(b.desa_id, 4, '0000')
from (
	select * from new_kampung_regional_update where status_aktifitas is true
	and kampung_kb_id not in (
		select kampung_kb_id from new_kampung_regional_update
		where status_aktifitas is true and status in ('DEL ')
	)
) b
where a.id = b.kampung_kb_id;


--update kampung yang akan dihapus
update new_kampung_kb a
set provinsi_id = lpad(b.provinsi_id, 2, '00') ,
	kabupaten_id = lpad(b.provinsi_id, 2, '00') || lpad(b.kabupaten_id, 2, '00'),
	kecamatan_id = lpad(b.provinsi_id, 2, '00') || lpad(b.kabupaten_id, 2, '00') || lpad(b.kecamatan_id, 2, '00'),
	desa_id = lpad(b.provinsi_id, 2, '00') || lpad(b.kabupaten_id, 2, '00') || lpad(b.kecamatan_id, 2, '00')|| lpad(b.desa_id, 4, '0000'),
	is_active = false
from (
	select * from new_kampung_regional_update where
	kampung_kb_id in (
		select kampung_kb_id from new_kampung_regional_update
		where status_aktifitas is true and status in ('DEL ')
		union all
		select kampung_kb_id from new_kampung_regional_update
		where status_aktifitas is false
	)
) b
where a.id = b.kampung_kb_id;


--update kampung regional not match siga
update new_kampung_kb a
set provinsi_id = lpad(b.siga_provinsi_id, 2, '00') ,
        kabupaten_id = lpad(b.siga_provinsi_id, 2, '00') || lpad(b.siga_kabupaten_id, 2, '00'),
        kecamatan_id = lpad(b.siga_provinsi_id, 2, '00') || lpad(b.siga_kabupaten_id, 2, '00') || lpad(b.siga_kecamatan_id, 2, '00'),
        desa_id = lpad(b.siga_provinsi_id, 2, '00') || lpad(b.siga_kabupaten_id, 2, '00') || lpad(b.siga_kecamatan_id, 2, '00')|| lpad(b.siga_keluarahan_id, 4, '0000')
from new_kampung_regional_not_match_update b
where a.id = b.kampung_kb_id;

