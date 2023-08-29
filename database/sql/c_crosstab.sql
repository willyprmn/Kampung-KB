-- FUNCTION: public.c_crosstab(character varying, character varying, character varying, character varying, character varying, character varying)

DROP FUNCTION IF EXISTS public.c_crosstab(
    character varying,
    character varying,
    character varying,
    character varying,
    character varying,
    character varying,
    character varying
);

CREATE OR REPLACE FUNCTION public.c_crosstab(
	eavsql_inarg character varying,
	resview character varying,
	rowid character varying,
	colid character varying,
	val character varying,
	agr character varying,
	group_2 text)

    RETURNS void
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE
    casesql varchar;
    dynsql varchar;
    r record;
	total varchar;

BEGIN
 dynsql='';

 for r in
      select * from pg_views where lower(viewname) = lower(resview)
  loop
      execute 'DROP VIEW ' || resview;
  end loop;

 casesql='SELECT DISTINCT ' || colid || ' AS v from (' || eavsql_inarg || ') eav ORDER BY ' || colid;
 FOR r IN EXECUTE casesql Loop
    dynsql = dynsql || ', ' || agr || '(CASE WHEN ' || colid || '=''' || r.v || ''' THEN ' || val || ' ELSE NULL END) AS ' || '"' || r.v || '"' ;
 END LOOP;

 total = '0 ';
 FOR r IN EXECUTE casesql Loop
    total = total || ' + COALESCE(' || '"' || r.v || '"' || ',0)';
 END LOOP;
 total = 'SELECT *, (' || total || ') as total from ( ';

 dynsql = 'CREATE VIEW ' || resview || ' AS ' || total || ' SELECT ' || (case when group_2 is not null then group_2 || ', ' else '' end)  || rowid || dynsql || ' from (' || eavsql_inarg || ') eav GROUP BY ' || (case when group_2 is not null then group_2 || ', ' else '' end) || rowid || ' ) a';
 RAISE NOTICE 'dynsql %1', dynsql;


 EXECUTE dynsql;

END
$BODY$;

ALTER FUNCTION public.c_crosstab(character varying, character varying, character varying, character varying, character varying, character varying)
    OWNER TO postgres;
