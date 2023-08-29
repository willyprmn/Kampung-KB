
--=======================================================================
--KAMPUNG KB
--=======================================================================

--insert kampung kb
insert into new_kampung_kb(id, nama, penanggungjawab_id, tanggal_pencanangan,
	provinsi_id, kabupaten_id, kecamatan_id, desa_id, rw,
	gambaran_umum, path_gambar, path_struktur, latitude, longitude,
	created_at, created_by, updated_at, updated_by, is_active,
	cakupan_wilayah
)
select
	id_kkb, nama_kkb, id_penangungjawab, tanggal_pencanangan,
		b.id provinsi_id, c.id kabupaten_id, d.id kecamatan_id, e.id desa_id, rw,
		gambaran_umum, path_gambar_kkb, path_struktur_bp, latitude, longitude,
		created_at, 5 created_by, updated_at, f.id updater_id, aktif,
		cakupan_wilayah
from (
	select id_kkb, nama_kkb, id_penangungjawab, tanggal_pencanangan,
		provinsi::json->>'id' provinsi_id, kabupaten::json->>'id' kabupaten_id, kecamatan::json->>'id' kecamatan_id, desa::json->>'id' desa_id, rw,
		gambaran_umum, path_gambar_kkb, path_struktur_bp, latitude, longitude,
		created_at, 5 created_by, updated_at, cast(updater_id as integer) updater_id, cast(aktif as boolean) aktif,
		cakupan_wilayah
	from kampung_kb where id_kkb not in (select kampung_kb_id from new_kampung_regional_not_match_update)
	--join with regional not match siga
	union all
	select id_kkb, nama_kkb, id_penangungjawab, tanggal_pencanangan,
		siga_provinsi_id provinsi_id, siga_provinsi_id || siga_kabupaten_id kabupaten_id,
		siga_provinsi_id || siga_kabupaten_id || siga_kecamatan_id kecamatan_id,
		siga_provinsi_id || siga_kabupaten_id || siga_kecamatan_id || siga_keluarahan_id desa_id, rw,
		gambaran_umum, path_gambar_kkb, path_struktur_bp, latitude, longitude,
		created_at, 5 created_by, updated_at, cast(updater_id as integer) updater_id, cast(aktif as boolean) aktif,
		cakupan_wilayah
	from kampung_kb a
	inner join new_kampung_regional_not_match_update b on a.id_kkb = b.kampung_kb_id
) a
left join provinsi b on a.provinsi_id = b.id
left join kabupaten c on a.kabupaten_id = c.id
left join kecamatan d on a.kecamatan_id = d.id
left join desa e on a.desa_id = e.id
left join users f on a.updater_id = f.id
--where id_kkb = 1099;
--where id_kkb = 9959
;

SELECT setval('new_kampung_kb_id_seq', max(id)) FROM new_kampung_kb;
