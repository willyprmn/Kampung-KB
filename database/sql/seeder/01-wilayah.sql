INSERT INTO new_provinsi (id, name)
SELECT id, nama FROM provinsi
;


INSERT INTO new_kabupaten (id, name)
SELECT id, nama FROM kabupaten
;

INSERT INTO new_kecamatan (id, name)
SELECT id, nama FROM kecamatan
;

INSERT INTO new_desa (id, name)
SELECT id, nama FROM desa
;

/* PROBABLY DELETED DESA, BECAUSE IT'S EXSITS ON USERS. AND SOME USER HAS RELATIONSHIP CERATED_BY WITH KKBPK AND KAMPUNG */
INSERT INTO new_desa (id, name) VALUES ('7409112008', 'Tokowuta');
INSERT INTO new_desa (id, name) VALUES ('7402212026', 'Besu');
INSERT INTO new_desa (id, name) VALUES ('7402052029', 'Lakomea');
INSERT INTO new_desa (id, name) VALUES ('7110032015', 'Motongkad Selatan');
INSERT INTO new_desa (id, name) VALUES ('3510142008', 'Sukojati');
INSERT INTO new_desa (id, name) VALUES ('1219062003', 'Bagan Baru');
