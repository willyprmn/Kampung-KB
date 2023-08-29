import React, {useState, useEffect, useCallback} from 'react';
import ReactDOM from 'react-dom';
import { Formik, Form } from 'formik';
import moment from 'moment';
import * as Yup from 'yup';
import {Button, Card, Alert} from 'react-bootstrap';
import InformationSection from './sections/Information';
import InpresSection from './sections/Inpres';
import PhotoSection from './sections/Photo';
import Axios from 'axios';

const FILE_SIZE = 5 * 1024 * 1000;

const CYCLE = {
    INIT: 'init',
    IDLE: 'idle',
    PENDING: 'peding',
    RESOLVED: 'resolved',
    REJECTED: 'rejected'
}

function Intervensi({intervensi: id, callback, update = ``, current = ``, store = ``}) {

    const [cycle, setCycle] = useState(CYCLE.INIT);
    const [intervensi, setIntervensi] = useState();
    const [schema, setSchema] = useState();
    const [isLocal, setIsLocal] = useState(false);

    const formRef = useCallback((formik) => {
        if (formik !== null && cycle === CYCLE.IDLE) {
            localStorage.setItem(current, JSON.stringify(formik.values));
        }
    }, [cycle]);

    const buildSchema = () => {

        setSchema(Yup.object().shape({
            judul: Yup.string()
                .required('Judul kegiatan harus diisi.')
                .max(255, 'Judul tidak boleh lebih dari 255 karakter'),
            inpres_kegiatan_id: Yup.array().min(1, 'Kategori Kegiatan harus dipilih.'),
            tanggal: Yup.string().required('Tanggal kegiatan harus diisi'),
            tempat: Yup.string().required('Tempat kegiatan harus diisi'),
            deskripsi: Yup.string().required('Deskripsi kegiatan harus diisi'),
            kategori_id: Yup.number().required('Seksi kegiatan harus dipilih'),
            instansis: Yup.array().min(1, 'Instansi minimal satu'),
            instansi_lainnya: Yup.array()
                .when('instansis', {
                    is: instansis => instansis.some((instansi) => instansi.id == 37),
                    then: Yup.array().of(
                        Yup.string().required('Instansi lainnya harus diisi')
                    ).min(1, 'Minimal terdapat satu instansi lainnya'),
                    otherwise: Yup.array().nullable()
                }),
            sasarans: Yup.array().min(1, 'Sasaran kegiatan minimal satu'),
            sasaran_lainnya: Yup.array()
                .when('sasarans', {
                    is: sasarans => sasarans.includes(9),
                    then: Yup.array().of(
                        Yup.string().required('Sasaran lainnya harus diisi')
                    ).min(1, 'Minimal terdapat satu sasaran kegiatan lainnya'),
                    otherwise: Yup.array().nullable()
                }),
            jenis_post_id: Yup.number().positive('Jenis post harus dipilih').required('Jenis post harus dipilih'),
            intervensi_gambars: Yup.array()
                .when('jenis_post_id', {
                    is: jenis_post_id => jenis_post_id === 2,
                    then: Yup.array().of(
                        Yup.object().shape({
                            caption: Yup.string()
                                .required('Harap masukan captionnya')
                                .max(255, 'Caption tidak boleh lebih dari 255 karakter'),
                            base64: Yup.string()
                                .required('Gambar harus dipilih')
                                .max(FILE_SIZE, 'Gambar tidak boleh lebih dari 5 MB'),
                        })
                    ).max(5, 'Maksimal lima gambar kegiatan'),
                    otherwise: Yup.array().of(
                        Yup.object().shape({
                            base64: Yup.string()
                                .required('Gambar harus dipilih')
                                .max(FILE_SIZE, 'Gambar tidak boleh lebih dari 5 MB')
                        })
                    )
                })
            })
        );

        setCycle(CYCLE.IDLE);
    }

    const handleSubmitIntervensi = async (values) => {

        setCycle(CYCLE.PENDING);

        const payload = {
            ...values,
            inpres_kegiatan_id: [...values.inpres_kegiatan_id].pop().id ?? null,
            sasarans: values.sasarans.filter(sasaran => sasaran !== 9),
            instansis: values.instansis.filter(instansi => !instansi.customOption).map(instansi => instansi.id),
            instansi_lainnya: values.instansis.filter(instansi => instansi.customOption).map(instansi => instansi.name),
            tanggal: typeof values.tanggal === 'string'
                ? moment(values.tanggal, 'DD / MM / YYYY')
                : values.tanggal
        }

        try {

            let response;
            switch (true) {
                case Boolean(update):
                    response = await Axios.put(update, payload);
                    break;
                case Boolean(store):
                    response = await Axios.post(store, payload);
                    break;
                default:
                    throw new Error('Method not found');
            }

            if (response) {
                alert('Data berhasil di submit');
                localStorage.removeItem(current);
                location.href = callback;
            }

        } catch (error) {
            alert('Terjadi kesalahan pada server, silahkan kontak administrator.');
            setCycle(CYCLE.IDLE);
        }


    }

    const getBase64FromUrl = async (url) => {
        const data = await fetch(url);
        const blob = await data.blob();
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = () => {
                const base64data = reader.result;
                resolve(base64data);
            }
        });
    }

    const fetchIntervensi = async () => {

        switch (true) {
            case Boolean(localStorage.getItem(current)):
                setIsLocal(true);
                return setIntervensi({
                    ...JSON.parse(localStorage.getItem(current)),
                    tanggal: moment(localStorage.getItem(current).tanggal).format(`DD / MM / YYYY`),
                });
            case Boolean(store):
                return setIntervensi({
                    judul: ``,
                    inpres_kegiatan_id: [],
                    tanggal: ``,
                    tempat: ``,
                    deskripsi: `<p>Kegiatan ini bertujuan untuk...., yang dihadiri oleh....., <br><span style="font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 1rem;">Setelah mengikuti kegiatan ini peserta menjadi ......</span></p><p><span style="font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 1rem;">Kegiatan ini terlaksana dikarenakan usaha yang dilakukan oleh.... dalam mengadvokasi/membuat proposal/mengajak...., sehingga dengan bantuan/fasilitasi ....</span><br></p><p><span style="font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 1rem;">Kegiatan ini terlaksanan dengan antusias peserta cukup baik.</span><br></p>`,
                    kategori_id: ``,
                    sasarans: [],
                    sasaran_lainnya: [],
                    instansis: [],
                    instansi_lainnya: [],
                    jenis_post_id: -1,
                    intervensi_gambars: [],
                });
            case Boolean(update):
                const response = await Axios.get(`/api/intervensi/${id}`, {
                    params: {
                        with: `instansis;sasarans;intervensi_gambars;inpres_kegiatan`
                    }
                });
                const data = response.data;
                return setIntervensi({
                    ...response.data,
                    inpres_kegiatan_id: data.inpres_kegiatan_id ? [data.inpres_kegiatan] : [{
                        id: null,
                        name: `* Lainnya`
                    }],
                    tanggal: moment(data.tanggal).format(`DD / MM / YYYY`),
                    sasarans: data.sasarans.map(sasaran => sasaran.id)
                        .filter((item, key, self) => self.findIndex(inner => inner === item) === key),
                    sasaran_lainnya: data.sasarans.filter(sasaran => sasaran.id === 9)
                        .map(sasaran => sasaran.pivot.sasaran_lainnya),
                    instansis: data.instansis
                        .map((instansi, key) => {
                            if (instansi.id === 37) {
                                return {
                                    customOption: true,
                                    name: instansi.pivot.instansi_lainnya,
                                    id: `new-id-${key}`,
                                }
                            } else {
                                return {
                                    id: instansi.id,
                                    name: instansi.name
                                }
                            }
                        }),
                    intervensi_gambars: await Promise.all(data.intervensi_gambars.map(async (gambar) => {
                        return {
                            ...gambar,
                            base64: await getBase64FromUrl(gambar.url),
                        }
                    }))
                });
            default:
                console.log('ga kemana2')
        }
    }

    useEffect(() => {
        fetchIntervensi();
    }, []);

    useEffect(() => {
        if (intervensi) {
            buildSchema();
        }
    }, [intervensi]);

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
                    initialValues={intervensi}
                    validationSchema={schema}
                    onSubmit={handleSubmitIntervensi}
                    innerRef={formRef}
                >
                    {formik => (
                        <Form noValidate onSubmit={formik.handleSubmit}>
                            {isLocal && (
                                <Alert variant="warning">Formulir dibawah diambil dari penyimpanan local dan belum di disimpan ke database.</Alert>
                            )}
                            <InformationSection formik={formik} intervensi={intervensi} />
                            <InpresSection formik={formik} intervensi={intervensi} />
                            <PhotoSection formik={formik} intervensi={intervensi} />
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

if (document.getElementById('intervensi-component')) {
    let profil = document.getElementById('intervensi-component');
    let props = {};
    for(let i = 0; i < Object.values(profil.attributes).length; i++) {
        props[profil.attributes.item(i).nodeName] = profil.attributes.item(i).nodeValue;
    }

    ReactDOM.render(<Intervensi {...props} />, profil);
}