import React, {useState, useEffect, useCallback} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import * as Yup from 'yup';
import { Formik, Form } from 'formik';
import {Button, Alert, Card} from 'react-bootstrap';

import Poktan from './sections/Poktan';
import SumberDana from './sections/SumberDana';
import Pokja from './sections/Pokja';
import Plkb from './sections/Plkb';
import Regulasi from './sections/Regulasi';
import PenggunaanData from './sections/PenggunaanData';
import Operasional from './sections/Operasional';
import mime from 'mime-types';

const CYCLE = {
    INIT: 'init',
    IDLE: 'idle',
    PENDING: 'peding',
    RESOLVED: 'resolved',
    REJECTED: 'rejected'
}

const RKM_ALLOWED_EXT = [
    // excel
    `application/vnd.ms-excel`,
    `application/vnd.openxmlformats-officedocument.spreadsheetml.sheet`,

    // word
    `text/csv`,
    `application/msword`,
    `application/vnd.openxmlformats-officedocument.wordprocessingml.document`,

    // pdf
    `application/pdf`,

    // image
    `image/*`

];

function Profil({kampung, current, store, callback}) {

    const [cycle, setCycle] = useState(CYCLE.INIT);
    const [programs, setPrograms] = useState([]);
    const [operasionals, setOperasionals] = useState([]);
    const [profil, setProfil] = useState(null);
    const [schema, setSchema] = useState();
    const [isLocal, setIsLocal] = useState(false);

    const formRef = useCallback((formik) => {
        if (formik !== null && cycle === CYCLE.IDLE) {
            localStorage.setItem(current, JSON.stringify(formik.values));
        }
    }, [cycle]);

    const fetchProfil = async () => {

        /** program */
        const responseProgram = await axios.get(`/api/program`, {
            params: {search: `groups.name:Poktan`}
        });
        setPrograms(responseProgram.data);

        /** operasional */
        const responseOperasional = await axios.get(`/api/operasional`);
        setOperasionals([...responseOperasional.data.map(item => {
            return {
                ...item,
                id: item.id.toString(),
            }
        })]);

        if (localStorage.getItem(current)) {
            setIsLocal(true);
            setProfil(JSON.parse(localStorage.getItem(current)));
        } else {

            const response = await axios.get(`/api/profil`, {
                params: {
                    search: `kampung_kb_id:${kampung};is_active:true;`,
                    searchJoin: `and`,
                    with: `profil_programs;profil_sumber_danas;profil_regulasis;profil_penggunaan_datas;profil_operasionals;archive`
                }
            });

            const data = response.data.data.pop();

            setProfil({
                archive: data?.archive || ``,
                programs: data?.profil_programs
                    ? data.profil_programs.reduce((acc, item) => {
                        return {
                            ...acc,
                            [item.program_id]: {program_flag: item.program_flag ?? null},
                        }
                    }, {})
                    : responseProgram.data.reduce((acc, item) => {
                        return {
                            ...acc,
                            [item.id]: {program_flag: null}
                        }
                    }, {}),
                sumber_danas: data?.profil_sumber_danas
                    ? data.profil_sumber_danas.map(dana => dana.sumber_dana_id.toString())
                    : [],
                pokja_pengurusan_flag: data?.pokja_pengurusan_flag ?? null,
                pokja_sk_flag: data?.pokja_sk_flag ?? null,
                pokja_jumlah: data?.pokja_jumlah || ``,
                pokja_pelatihan_flag: data?.pokja_pelatihan_flag ?? null,
                pokja_jumlah_terlatih: data?.pokja_jumlah_terlatih || ``,
                pokja_pelatihan_desc: data?.pokja_pelatihan_desc || ``,
                plkb_pendamping_flag: data?.plkb_pendamping_flag  ?? null,
                plkb_pengarah_id : data?.plkb_pengarah_id || ``,
                plkb_pengarah_lainnya: data?.plkb_pengarah_lainnya || ``,
                plkb_nip: data?.plkb_nip || ``,
                plkb_nama: data?.plkb_nama || ``,
                plkb_kontak: data?.plkb_kontak || ``,
                regulasi_flag: data?.regulasi_flag  ?? null,
                regulasis: data?.profil_regulasis ?
                    data.profil_regulasis.map(regulasi => regulasi.regulasi_id.toString())
                    : [],
                rencana_kerja_masyarakat_flag: data?.rencana_kerja_masyarakat_flag  ?? null,
                penggunaan_data_flag: data?.penggunaan_data_flag  ?? null,
                penggunaan_datas: data?.profil_penggunaan_datas
                    ? data.profil_penggunaan_datas.map(item => item.penggunaan_data_id.toString())
                    : [],
                operasionals: data?.profil_operasionals
                    ? data.profil_operasionals.reduce((acc, item) => {
                        return {
                            ...acc,
                            [item.operasional_id]: {
                                operasional_flag: item.operasional_flag ?? null,
                                frekuensi_id: item.frekuensi_id || -1,
                                frekuensi_lainnya: item.frekuensi_lainnya || ``,
                            }
                        }
                    }, {})
                    : responseOperasional.data.reduce((acc, item) => {
                        return {
                            ...acc,
                            [item.id]: {
                                operasional_flag: null,
                                frekuensi_id: ``,
                                frekuensi_lainnya: ``,
                            }
                        }
                    }, {}),
            });
        }
    }


    const handleSubmit = async (value) => {

        setCycle(CYCLE.PENDING);

        const payload = {
            programs: value.programs,
            sumber_danas: value.sumber_danas,

            // pokja
            pokja_pengurusan_flag: value.pokja_pengurusan_flag,
            ...(value.pokja_pengurusan_flag
                ? {
                    pokja_sk_flag: value.pokja_sk_flag,
                    pokja_jumlah: value.pokja_jumlah,
                    pokja_pelatihan_flag: value.pokja_pelatihan_flag,
                    ...(value.pokja_pelatihan_flag
                        ? {
                            pokja_jumlah_terlatih: value.pokja_jumlah_terlatih,
                            pokja_pelatihan_desc: value.pokja_pelatihan_desc,
                        }
                        : {}
                    )
                }
                : {}
            ),

            // plkb
            plkb_pendamping_flag: value.plkb_pendamping_flag,
            ...(value.plkb_pendamping_flag
                ? {plkb_nip: value.plkb_nip}
                : {
                    plkb_pengarah_id: value.plkb_pengarah_id,
                    ...(value.plkb_pengarah_id == 9
                        ? {plkb_pengarah_lainnya: value.plkb_pengarah_lainnya}
                        : {}
                    )
                }
            ),
            plkb_nama: value.plkb_nama,
            plkb_kontak: value.plkb_kontak,

            // regulasi
            regulasi_flag: value.regulasi_flag,
            ...(value.regulasi_flag
                ? {regulasis: value.regulasis}
                : {}
            ),

            // rkm
            rencana_kerja_masyarakat_flag: value.rencana_kerja_masyarakat_flag,
            ...(value.rencana_kerja_masyarakat_flag
                ? {
                    rkm: value.rkm,
                    penggunaan_data_flag: value.penggunaan_data_flag,
                    ...(value.penggunaan_data_flag
                        ? {penggunaan_datas: value.penggunaan_datas}
                        : {}
                    )
                }
                : {}
            ),

            // operasionals
            operasionals: value.operasionals
        }

        let form = new FormData();
        Object.keys(payload).forEach(key => {
            if (typeof payload[key] === 'object') {
                if (key === 'rkm') {
                    form.append(`rkm`, payload[key]);
                } else {
                    Object.entries(payload[key]).forEach(([id, item]) => {
                        if (typeof item === 'object') {
                            Object.entries(item).forEach(([field, value]) => {
                                form.append(`${key}[${id}][${field}]`, value);
                            });
                        } else {
                            form.append(`${key}[${id}]`, item);
                        }
                    });
                }
            } else {
                form.append(key, payload[key]);
            }
        });


        try {

            const response = await axios.post(store, form, {
                headers: {'Content-Type': `multipart/form-data`}
            });

            if (response) {
                alert('Data berhasil di submit');
                localStorage.removeItem(current)
                location.href = callback;
            }
        } catch (error) {
            alert('Terjadi kesalahan pada server, silahkan kontak administrator.');
            setCycle(CYCLE.IDLE);
        }

    }


    const buildSchema = () => {

        const FILE_SIZE = 10000 * 1024;
        const FORMAT = [
            'doc',
            'pdf',
            'docx',
            'xls',
            'xlsx',
            'jpg',
            'jpeg',
            'png',
            'gif',
        ];

        console.log(`profil`, profil)

        setSchema(Yup.object().shape({
            archive: Yup.object().nullable(),
            programs: Yup.object().shape(
                programs.reduce((acc, item) => {
                    return {
                        ...acc,
                        [item.id]: Yup.object().shape({
                            program_flag: Yup.boolean()
                                .required('Seluruh profil kepemilikan harus diisi.')
                                .nullable()
                        })
                    }
                }, {})
            ),
            sumber_danas: Yup.array(),
            pokja_pengurusan_flag: Yup.boolean()
                .required('Kepengurusan Pokja harus diisi.')
                .nullable(),
            pokja_sk_flag: Yup.boolean()
                .when('pokja_pengurusan_flag', {
                    is: true,
                    then: Yup.boolean()
                        .required('SK Pokja harus diisi.')
                        .nullable(),
                    otherwise: Yup.boolean().nullable()
                }),

            pokja_jumlah: Yup.number()
                .when('pokja_pengurusan_flag', {
                    is: true,
                    then: Yup.number()
                        .required('Jumlah Anggota Pokja harus diisi')
                        .nullable(),
                    otherwise: Yup.number().nullable(),
                }),
            pokja_pelatihan_flag: Yup.boolean()
                .when('pokja_pengurusan_flag', {
                    is: true,
                    then: Yup.boolean()
                        .required('Pelatihan/Sosialisasi Pokja harus diisi.')
                        .nullable(),
                    otherwise: Yup.boolean().nullable(),
                }),

            pokja_jumlah_terlatih:
                Yup.number()
                    .when(['pokja_pengurusan_flag', 'pokja_pelatihan_flag'], {
                        is: true,
                        then: Yup.number()
                            .required('Apabila terdapat pelatihan Pokja, maka pokja terlatih harus diisi.')
                            .max(Yup.ref('pokja_jumlah'), "Jumlah Anggota Pokja terlatih tidak boleh melebihi Jumlah Anggota Pokja.")
                            .nullable(),
                        otherwise: Yup.number().nullable()
                    }),
            pokja_pelatihan_desc: Yup.string()
                .when(['pokja_pengurusan_flag', 'pokja_pelatihan_flag'], {
                    is: true,
                    then: Yup.string()
                        .required('Apabila terdapat pelatihan Pokja, harap cantumkan detail pelatihannya.')
                        .nullable(),
                    otherwise: Yup.string().nullable(),
                }),
            plkb_pendamping_flag: Yup.boolean()
                .required('PLKB harus diisi')
                .nullable(),
            plkb_nip: Yup.string()
                .when('plkb_pendamping_flag', {
                    is: true,
                    then: Yup.string()
                        .required('Apabila Terdapat Pendampingan PLKB, harap cantumkan NIP-nya.')
                        .nullable(),
                    otherwise: Yup.string().nullable(),
                }),
            plkb_pengarah_id: Yup.number()
                .when('plkb_pendamping_flag', {
                    is: false,
                    then: Yup.number()
                        .required('Apabila tidak ada PLKB pendamping, harap cantumkan pengarah')
                        .nullable(),
                    otherwise: Yup.number().nullable()
                }),
            plkb_pengarah_lainnya: Yup.string()
                .when(['plkb_pendamping_flag', 'plkb_pengarah_id'], {
                    is: (plkb_pendamping_flag, plkb_pengarah_id) => !plkb_pendamping_flag && plkb_pengarah_id === 9,
                    then: Yup.string()
                        .required('Harap cantumkan jabatan pengarah lainnya')
                        .nullable(),
                    otherwise: Yup.string().nullable(),
                }),
            plkb_nama: Yup.string()
                .required('Nama harus diisi.')
                .nullable(),
            plkb_kontak: Yup.string()
                .required('Kontak harus diisi dengan email atau nomor telepon.')
                .nullable(),
            regulasi_flag: Yup.boolean()
                .required('Regulasi pemerintah daerah harus diisi.')
                .nullable(),
            regulasis: Yup.array()
                .when('regulasi_flag', {
                    is: true,
                    then: Yup.array()
                        .required('Apabila terdapat regulasi, harap pilih regulasi pemerintah daerah.')
                        .min(1, 'Minimal satu regulasi dipilih.')
                        .nullable()
                }),
            rencana_kerja_masyarakat_flag: Yup.boolean()
                .required('Rencana kegiatan harus dipilih')
                .nullable(),
            rkm: Yup.mixed()
                .when(['rencana_kerja_masyarakat_flag', 'archive'], {
                    is: (rencana_kerja_masyarakat_flag, archive) => {
                        return archive?.id === undefined && rencana_kerja_masyarakat_flag === true
                    },
                    then: Yup.mixed()
                        .test(
                            'FILE_EXIST',
                            'Apabila terdapat Rencana Kegiatan Masyarakat, harap lampiran dalam bentuk file',
                            value =>  value?.size !== undefined,
                        )
                        .test(
                            'FILE_SIZE',
                            'File tidak boleh lebih besar dari 10 MB.',
                            value => !value || (value && value.size <= FILE_SIZE),
                        )
                        .test(
                            'FILE_TYPE',
                            'Format yang diperbolehkan hanya .pdf, .xls, .xlsx, .doc, .docx dan image',
                            value => value && FORMAT.includes(mime.extension(value.type)),
                        ),
                    otherwise: Yup.mixed().nullable(),
                }),
            penggunaan_data_flag: Yup.boolean()
                .when('rencana_kerja_masyarakat_flag', {
                    is: true,
                    then: Yup.boolean()
                        .required('Apabila terdapat rencana kegiatan, penggunaan data harus dipilih')
                        .nullable(),
                    otherwise: Yup.boolean().nullable(),
                }),
            penggunaan_datas: Yup.array()
                .when(['penggunaan_data_flag', 'rencana_kerja_masyarakat_flag'], {
                    is: true,
                    then: Yup.array()
                        .required('Harap pilih penggunaan data apabila terdapat rencana kerja dan penggunaan data.')
                        .min(1, 'Minimal pilih satu penggunaan data apabila ada.')
                        .nullable(),
                    otherwise: Yup.array().nullable()
                }),
            operasionals: Yup.object().shape(
                operasionals.reduce((acc, item) => {
                    return {
                        ...acc,
                        [item.id]: Yup.object().shape({
                            operasional_flag: Yup.boolean()
                                .required('Seluruh mekanisme operasional harus dipilih')
                                .nullable(),
                            frekuensi_id: Yup.number()
                                .when('operasional_flag', {
                                    is: true,
                                    then: Yup.number()
                                        .positive('Harap pilih frekuensinya.')
                                        .required('Harap pilih frekuensinya.')
                                        .nullable(),
                                    otherwise: Yup.number().nullable(),
                                }),
                            frekuensi_lainnya: Yup.string()
                                .when(['operasional_flag', 'frekuensi_id'], {
                                    is: (operasional_flag, frekuensi_id) => operasional_flag === true && frekuensi_id === 6,
                                    then: Yup.string()
                                        .required('Harap cantumkan frekuensi lainnya.')
                                        .nullable(),
                                    otherwise: Yup.string().nullable(),
                                }),
                        })
                    }
                }, {})
            ),
        }));

        setCycle(CYCLE.IDLE);
    }

    useEffect(() => {
        fetchProfil();
    }, []);

    useEffect(() => {

        if (profil) {
            buildSchema();
        }

    }, [profil]);



    return (
        <>
            {cycle === CYCLE.INIT && (
                <Card>
                    <div className="overlay">
                        <i className="fas fa-2x fa-sync-alt"></i>
                    </div>
                    <Card.Header>
                        <Card.Title>Memuat...</Card.Title>
                    </Card.Header>
                    <Card.Body>
                        <p>Mengambil data dari database...</p>
                    </Card.Body>
                </Card>
            )}

            {[CYCLE.IDLE, CYCLE.PENDING].includes(cycle) && (
                <Formik
                    enableReinitialize={true}
                    initialValues={profil}
                    validationSchema={schema}
                    onSubmit={handleSubmit}
                    innerRef={formRef}
                >
                    {formik => (
                        <Form>
                            {isLocal && (
                                <Alert variant="warning">Formulir dibawah diambil dari penyimpanan local dan belum di disimpan ke database.</Alert>
                            )}
                            <Poktan formik={formik} programs={programs} />
                            <hr />
                            <h3>Pendukung Kampung KB</h3>
                            <SumberDana formik={formik} />
                            <Pokja formik={formik} />
                            <Plkb formik={formik} />
                            <Regulasi formik={formik} />
                            <PenggunaanData formik={formik} rkmAllowedExt={RKM_ALLOWED_EXT} />

                            <hr />
                            <h3>Mekanisme Operasional</h3>
                            <Operasional formik={formik} operasionals={operasionals} />

                            {!formik.isValid && formik.submitCount > 0 && (
                                <Alert variant="danger">Terjadi Kesalahan dalam penginputan. Harap periksa kembali</Alert>
                            )}

                            {cycle === CYCLE.PENDING ? (
                                <Button variant="secondary" disabled>
                                    Mohon Tunggu
                                </Button>
                            ) : (
                                <Button type="submit" variant="success">
                                    Simpan
                                </Button>
                            )}

                            {sessionStorage.getItem('debug') && (
                                <>
                                    <pre>{JSON.stringify(formik.values, null, 2)}</pre>
                                    <pre>{JSON.stringify(JSON.parse(localStorage.getItem(current)), null, 2)}</pre>
                                    <pre>{JSON.stringify(formik.errors, null, 2)}</pre>
                                </>
                            )}
                        </Form>
                    )}
                </Formik>
            )}
        </>
    );
}

if (document.getElementById('profil-component')) {
    let profil = document.getElementById('profil-component');
    let props = {};
    for(let i = 0; i < Object.values(profil.attributes).length; i++) {
        props[profil.attributes.item(i).nodeName] = profil.attributes.item(i).nodeValue;
    }

    ReactDOM.render(<Profil {...props} />, profil);
}