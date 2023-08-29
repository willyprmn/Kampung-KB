DO
$do$
BEGIN
  EXECUTE (
   SELECT 'DROP TABLE ' || string_agg(format('%I.%I', schemaname, tablename), ', ') || ' CASCADE' -- optional
   FROM   pg_catalog.pg_tables t
   WHERE  schemaname NOT LIKE 'pg\_%'     -- exclude system schemas
   AND    tablename LIKE 'new_' || '%'  -- your table name prefix
   );
END
$do$;

drop table if exists failed_jobs;
drop table if exists password_resets;
drop table if exists activity_log;
drop table if exists migrations;
