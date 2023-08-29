--insert kriteria
insert into new_kampung_kriteria(kampung_kb_id, kriteria_id, kriteria_flag)
select a.id_kkb,
	c.id kriteria_id,
	cast(case when b.kriteria_1 = '1' then true when b.kriteria_1 = '0' then false else null end as boolean) kriteria_flag
from kampung_kb a
left join kriteria_terpilih b on a.id_kkb = b.id_kkb
left join new_kriteria c on c.name = 'Kriteria 1'
--where a.id_kkb = 1099
union all
select a.id_kkb,
	c.id kriteria_id,
	cast(case when b.kriteria_2 = '1' then true when b.kriteria_2 = '0' then false else null end as boolean) kriteria_flag
from kampung_kb a
left join kriteria_terpilih b on a.id_kkb = b.id_kkb
left join new_kriteria c on c.name = 'Kriteria 2'
--where a.id_kkb = 1099
union all
select a.id_kkb,
	c.id kriteria_id,
	cast(case when b.kriteria_3 = '1' then true when b.kriteria_3 = '0' then false else null end as boolean) kriteria_flag
from kampung_kb a
left join kriteria_terpilih b on a.id_kkb = b.id_kkb
left join new_kriteria c on c.name = 'Kriteria 3'
--where a.id_kkb = 1099
;

SELECT setval('new_kampung_kriteria_id_seq', max(id)) FROM new_kampung_kriteria;