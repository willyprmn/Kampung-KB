
--insert intervensi sasaran
insert into new_intervensi_sasaran(intervensi_id, sasaran_id, sasaran_lainnya)
select b.id_intervensi,
	case
		when c.id is null
		then d.id
		else c.id
	end AS sasaran_id,
	case
		when c.id is not null
		then null
		else sasaran_kegiatan
	end AS sasaran_lainnya
from (
	SELECT id_intervensi, sasaran_kegiatan
	FROM sasaran_kegiatan
	GROUP BY id_intervensi, sasaran_kegiatan
) b
left join new_sasaran c on b.sasaran_kegiatan = c.name
left join new_sasaran d on d.name = 'Lainnya'
;

SELECT setval('new_intervensi_sasaran_id_seq', max(id)) FROM new_intervensi_sasaran;