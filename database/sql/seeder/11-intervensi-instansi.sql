insert into new_intervensi_instansi(intervensi_id, instansi_id, instansi_lainnya)
select b.id,
	case when c.id is null then d.id else c.id end instansi_id,
	case when c.id is not null then null else b.instansi_pembina_kegiatan  end instansi_lainnya
from (
	select DISTINCT new_intervensi.id, instansi.instansi_pembina_kegiatan
	FROM instansi
	INNER JOIN new_intervensi
		ON new_intervensi.id = instansi.id_intervensi
) b
left join new_instansi c on trim(b.instansi_pembina_kegiatan) = c.name
left join new_instansi d on d.name = 'Lainnya';

SELECT setval('new_intervensi_instansi_id_seq', max(id)) FROM new_intervensi_instansi;