SELECT * FROM concentrado_telefonia WHERE d_phone_number = '7223389421';

select distinct(d_phone_number) from concentrado_telefonia
where d_phone_number = '7223389421';
and c_dialstatus in ('ANSWER')

INSERT INTO monitor (marca_monitor, serie_monitor)
SELECT marca_monitor, serie_monitor FROM estaciones; WHERE CLAVE=@CLAVESECRETOSDENEGUS