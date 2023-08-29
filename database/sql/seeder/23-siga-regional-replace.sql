--provinsi
insert into new_provinsi(id, name)
select kodedepdagri_prov id, nama_provinsi from new_siga_regionals
group by kodedepdagri_prov, nama_provinsi;

--kabupaten
insert into new_kabupaten(id, name)
select kodedepdagri_prov || kodedepdagri_kabupaten id, nama_kabupaten
from new_siga_regionals
group by kodedepdagri_prov, kodedepdagri_kabupaten, nama_kabupaten;

--kecamatan
insert into new_kecamatan(id, name)
--jumlah new siga lebih banyak
select kodedepdagri_prov || kodedepdagri_kabupaten || kodedepdagri_kecamatan id
	,nama_kecamatan
from new_siga_regionals
group by kodedepdagri_prov, kodedepdagri_kabupaten, kodedepdagri_kecamatan, nama_kecamatan;

--desa
insert into new_desa(id, name)
select kodedepdagri_prov || kodedepdagri_kabupaten || kodedepdagri_kecamatan || kodedepdagri_kelurahan id
	,nama_kelurahan
from new_siga_regionals
group by kodedepdagri_prov, kodedepdagri_kabupaten, kodedepdagri_kecamatan, kodedepdagri_kelurahan, nama_kelurahan;

/* some kampung still use this desa */
INSERT INTO new_desa (id, name) VALUES ('1219062003', 'Bagan Baru');

