import React, {useState, useEffect} from 'react';
import axios from 'axios';
import { FieldArray, Field } from 'formik';
import {Typeahead} from 'react-bootstrap-typeahead';
import RadioGroup from '../../../components/forms/RadioGroup';
import CheckGroup from '../../../components/forms/CheckGroup';
import {
    Button,
    Card,
    Col,
    Form,
    Row,
    InputGroup,
} from 'react-bootstrap';

import 'react-bootstrap-typeahead/css/Typeahead.css';


export default function Inpres({formik, intervensi}) {

    const [kategories, setKategories] = useState([]);
    const [sasarans, setSasarans] = useState([]);
    const [instansis, setInstannsis] = useState([]);
    const [isLoadInstansi, setIsLoadInstansi] = useState(false);
    const [isLoadInpresKegiatan, setIsLoadInpresKegiatan] = useState(false);
    const [inpresKegiatans, setInpresKegiatas] = useState([]);

    const fetchInpresKegiatans = async () => {
        setIsLoadInpresKegiatan(true);
        const response = await axios.get(`/api/inpres-kegiatan`, {
            params: {
                with: `keywords;instansis`
            }
        });
        setInpresKegiatas([...response.data, {
            id: null,
            name: `* Lainnya`
        }]);
        setIsLoadInpresKegiatan(false)
    }

    const handleFilterInpresKegiatan = (option, props) => {
        const keywords = formik.values.judul?.toLowerCase().split(' ').map(word => `\\b${word}\\b`).join('|');
        return option.name?.toLowerCase().search(keywords) !== -1
            || option.keywords?.filter(keyword => keyword.name.toLowerCase().search(keywords) !== -1).length > 0
            || option.indikator?.toLowerCase().search(keywords) !== -1
            || option.id == null
        ;
    }

    const handleChangeInpresKegiatan = (selected) => {
        formik.setFieldValue('inpres_kegiatan_id', selected);
    }


    const fetchInstansis = async () => {
        setIsLoadInstansi(true);
        const response = await axios.get(`/api/instansi`, {
            params: {
                with: `keywords`
            }
        });
        setInstannsis(response.data);
        setIsLoadInstansi(false);
    }

    const handleFilterInstansi = (option, props) => {
        const keywords = props.text?.toLowerCase().split(' ').map(word => `\\b${word}\\b`).join('|');
        return option.name?.toLowerCase().search(keywords) !== -1
            || option.keywords?.filter(keyword => keyword.name.toLowerCase().search(keywords) !== -1).length > 0
        ;
    }

    const handleChangeKategori = (value) => {
        formik.setFieldValue('kategori_id', value);
    }

    const handleChangeSasaran = (value) => {
        formik.setFieldValue('sasarans', value);
    }

    const handleChangeInstansi = (selected) => {
        const uniques = selected.filter((item, key, self) => self.findIndex((inner) => (inner.id === item.id) || (inner.name === item.name)) === key);
        formik.setFieldValue('instansis', [...uniques]);
    }

    const fetchKategories = async () => {
        const response = await axios.get(`/api/kategori`);
        setKategories(response.data.data);
    }

    const fetchSasarans = async () => {
        const response = await axios.get(`/api/sasaran`);
        setSasarans(response.data.data);
    }

    useEffect(() => {
        fetchKategories();
        fetchInpresKegiatans();
        fetchInstansis();
        fetchSasarans();
    }, []);

    return (
        <Card>
            <Card.Header>
                <Card.Title>Step 2 - Tambahkan informasi lebih lanjut mengenai kegiatan yang dilakukan.</Card.Title>
            </Card.Header>
            <Card.Body>
                <Form.Group>
                    <Form.Label>Seksi Kegiatan *</Form.Label>
                    <RadioGroup
                        value={formik.values.kategori_id}
                        name="kategori_id"
                        labelKey="name"
                        onChange={handleChangeKategori}
                        options={kategories}
                    />
                    {formik.touched.kategori_id && formik.errors.kategori_id ? (
                        <div style={{display: `block`}} className="invalid-feedback">{formik.errors.kategori_id}</div>
                    ) : ``}
                </Form.Group>
                <Form.Group>
                    <Form.Label>Kategori Kegiatan *</Form.Label>
                    <Typeahead
                        newSelectionPrefix="Kegiatan Lainnya: "
                        filterBy={handleFilterInpresKegiatan}
                        id="kegiatan-inpres"
                        isLoading={isLoadInpresKegiatan}
                        labelKey="name"
                        options={inpresKegiatans}
                        name="inpres_kegiatan_id"
                        selected={formik.values.inpres_kegiatan_id || []}
                        onChange={handleChangeInpresKegiatan}
                        renderMenuItemChildren={(option) => (
                            <div>
                                {option.name}
                                {option.keywords && option.keywords.length > 0 && (
                                    <div>
                                        <small>Keywords: {option.keywords.map(keyword => `#${keyword.name},`).join(' ')}</small>
                                    </div>
                                )}
                            </div>
                        )}
                        isInvalid={formik.touched.inpres_kegiatan_id && formik.errors.inpres_kegiatan_id
                            ? true
                            : false
                        }
                    />
                    {formik.touched.inpres_kegiatan_id && formik.errors.inpres_kegiatan_id ? (
                        <div style={{display: `block`}} className="invalid-feedback">{formik.errors.inpres_kegiatan_id}</div>
                    ) : ``}
                </Form.Group>
                <Form.Group>
                    <Form.Label>Peserta Kegiatan *</Form.Label>
                    <CheckGroup
                        selected={formik.values.sasarans}
                        name="sasarans"
                        labelKey="name"
                        onChange={handleChangeSasaran}
                        options={sasarans}
                    />
                    {formik.values.sasarans?.includes(9) ? (
                        <>
                            <Card>
                                <Card.Header>
                                    <Card.Title>Peserta Kegiatan Lainnya</Card.Title>
                                </Card.Header>
                                <Card.Body>
                                    <FieldArray
                                        name="sasaran_lainnya"
                                        render={helper => (
                                            <>
                                                {formik.values.sasaran_lainnya && formik.values.sasaran_lainnya.map((sasaran, key) => (
                                                    <Field
                                                        key={key}
                                                        name={`sasaran_lainnya[${key}]`}
                                                    >
                                                        {({field, meta}) => (
                                                            <>
                                                                <InputGroup className="mt-3">
                                                                    <Form.Control
                                                                        {...field}
                                                                        placeholder="Sasaran Lainnya"
                                                                        aria-describedby={`hapus${key}`}
                                                                        isInvalid={meta.touched && meta.error}
                                                                    />
                                                                    <Button id={`hapus${key}`}  variant={`danger`} onClick={() => helper.remove(key)}>Hapus</Button>
                                                                </InputGroup>
                                                                {meta.touched && meta.error ? (
                                                                    <div style={{display: `block`}} className="invalid-feedback">{meta.error}</div>
                                                                ) : ``}
                                                            </>
                                                        )}
                                                    </Field>
                                                ))}
                                                <Button className="mt-3" onClick={() => helper.push(``)} variant="primary">Tambah</Button>
                                                {formik.touched.sasaran_lainnya && formik.errors.sasaran_lainnya && typeof formik.errors.sasaran_lainnya === 'string' ? (
                                                    <div style={{display: `block`}} className="invalid-feedback">{formik.errors.sasaran_lainnya}</div>
                                                ) : ``}
                                            </>
                                        )}
                                    />
                                </Card.Body>
                            </Card>
                        </>
                    ) : ``}
                    {formik.touched.sasarans && formik.errors.sasarans ? (
                        <div style={{display: `block`}} className="invalid-feedback">{formik.errors.sasarans}</div>
                    ) : ``}
                </Form.Group>
                <Form.Group>
                    <Form.Label>Instansi *</Form.Label>
                    <Typeahead
                        allowNew
                        newSelectionPrefix="Instansi Lainnya: "
                        multiple
                        filterBy={handleFilterInstansi}
                        id="instansis"
                        isLoading={isLoadInstansi}
                        labelKey="name"
                        options={instansis}
                        selected={formik.values.instansis}
                        name="instansis"
                        onChange={handleChangeInstansi}
                        renderMenuItemChildren={(option) => (
                            <div>
                                {option.name}
                                {option.keywords && option.keywords.length > 0 && (
                                    <div>
                                        <small>Keywords: {option.keywords.map(keyword => `#${keyword.name},`).join(' ')}</small>
                                    </div>
                                )}
                            </div>
                        )}
                        isInvalid={formik.touched.instansis && formik.errors.instansis
                            ? true
                            : false
                        }
                    />
                    {formik.values.instansis?.some(instansi => instansi.id === 37) ? (
                        <>
                            <Card className="mt-3">
                                <Card.Header><Card.Title>Instansi Lainnya</Card.Title></Card.Header>
                                <Card.Body>
                                    <FieldArray
                                        name="instansi_lainnya"
                                        render={helper => (
                                            <>
                                                {formik.values.instansi_lainnya && formik.values.instansi_lainnya.map((instansi, key) => (
                                                    <Field
                                                        key={key}
                                                        name={`instansi_lainnya[${key}]`}
                                                    >
                                                        {({field, meta}) => (
                                                            <>
                                                                <InputGroup className="mt-3">
                                                                    <Form.Control
                                                                        {...field}
                                                                        placeholder="Instansi Lainnya"
                                                                        aria-describedby={`hapus${key}`}
                                                                        isInvalid={meta.touched && meta.error}
                                                                    />
                                                                    <Button id={`hapus${key}`}  variant={`danger`} onClick={() => helper.remove(key)}>Hapus</Button>
                                                                </InputGroup>
                                                                {meta.touched && meta.error ? (
                                                                    <div style={{display: `block`}} className="invalid-feedback">{meta.error}</div>
                                                                ) : ``}
                                                            </>
                                                        )}
                                                    </Field>
                                                ))}
                                                <Button className="mt-3" onClick={() => helper.push(``)} variant="primary">Tambah</Button>
                                                {formik.touched.instansi_lainnya && formik.errors.instansi_lainnya && typeof formik.errors.instansi_lainnya === 'string' ? (
                                                    <div style={{display: `block`}} className="invalid-feedback">{formik.errors.instansi_lainnya}</div>
                                                ) : ``}
                                            </>
                                        )}
                                    />
                                </Card.Body>
                            </Card>
                        </>
                    ) : ``}
                    {formik.touched.instansis && formik.errors.instansis ? (
                        <div style={{display: `block`}} className="invalid-feedback">{formik.errors.instansis}</div>
                    ) : ``}
                </Form.Group>
            </Card.Body>
        </Card>
    )
}