import React, {useState, useEffect} from 'react';
import axios from 'axios';
import Radio from '../../../components/forms/Radio';
import {Field} from 'formik';
import {Card, Col, Form, Row} from 'react-bootstrap';

export default function Plkb({formik}) {

    const [pengarahs, setPengarahs] = useState([]);

    const hasPlkb = () => {
        return formik.values.plkb_pendamping_flag && formik.values.plkb_pendamping_flag !== 'false';
    }

    const fetchPengarahs = async () => {
        const response = await axios.get(`/api/plkb-pengarah`);
        setPengarahs(response.data.map(item => {
            return {
                ...item,
                id: item.id.toString(),
            }
        }));
    }

    useEffect(() => {
        fetchPengarahs();
    }, []);

    return (
        <Card>
            {formik.isSubmitting && (
                <div className="overlay dark">
                    <i className="fas fa-2x fa-sync-alt"></i>
                </div>
            )}
            <Field name="plkb_pendamping_flag">
                {field => (
                    <Card.Header className={field.meta.error && field.meta.touched ? `text-danger` : null}>
                        <Card.Title>
                            PLKB/PKB Sebagai Pendamping dan Pengarah Kegiatan *
                            {field.meta.touched && field.meta.error && (
                                <>
                                    <br />
                                    <small>* {field.meta.error}</small>
                                </>
                            )}
                        </Card.Title>
                        <div className="card-tools">
                            <Radio {...field} id="plkb_pendamping_flag" />
                        </div>
                    </Card.Header>
                )}
            </Field>
            <Card.Body>
                {hasPlkb() ? (
                    <Field name="plkb_nip">
                        {({field, meta}) => (
                            <Form.Group as={Row} className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                <Form.Label column sm={7}>
                                    NIP (Nomor Induk Pegawai) *
                                    {meta.touched && meta.error && (
                                        <>
                                            <br />
                                            <small>* {meta.error}</small>
                                        </>
                                    )}
                                </Form.Label>
                                <Col sm={5}>
                                    <Form.Control
                                        {...field}
                                        isInvalid={meta.touched && meta.error}
                                    />
                                </Col>
                            </Form.Group>
                        )}
                    </Field>
                ) : (
                    <>
                        <Field name="plkb_pengarah_id">
                            {({field, meta}) => (
                                <Form.Group as={Row} className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                    <Form.Label column sm={7}>
                                        Diarahkan Oleh *
                                        {meta.touched && meta.error && (
                                            <>
                                                <br />
                                                <small>* {meta.error}</small>
                                            </>
                                        )}
                                    </Form.Label>
                                    <Col sm={5}>
                                        <Form.Control as="select"
                                            {...field}
                                            defaultValue={-1}
                                            isInvalid={meta.touched && meta.error}
                                        >
                                            <option value={-1} disabled>Pilih...</option>
                                            {pengarahs && pengarahs.map((pengarah, key) => (
                                                <option key={key} value={pengarah.id}>{pengarah.name}</option>
                                            ))}
                                        </Form.Control>
                                    </Col>
                                </Form.Group>
                            )}
                        </Field>
                        {formik.values.plkb_pengarah_id && formik.values.plkb_pengarah_id == 9 && (
                            <Field name="plkb_pengarah_lainnya">
                                {({field, meta}) => (
                                    <Form.Group as={Row} className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                        <Form.Label column sm={7}>
                                            Sebutan/Jabatan Pengarah *
                                            {meta.touched && meta.error && (
                                                <>
                                                    <br />
                                                    <small>* {meta.error}</small>
                                                </>
                                            )}
                                        </Form.Label>
                                        <Col sm={5}>
                                            <Form.Control
                                                {...field}
                                                isInvalid={meta.touched && meta.error}
                                            />
                                        </Col>
                                    </Form.Group>
                                )}
                            </Field>
                        )}
                    </>
                )}


                <Field name="plkb_nama">
                    {({field, meta}) => (
                        <Form.Group as={Row} className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                            <Form.Label column sm={7}>
                                Nama *
                                {meta.touched && meta.error && (
                                    <>
                                        <br />
                                        <small>* {meta.error}</small>
                                    </>
                                )}
                            </Form.Label>
                            <Col sm={5}>
                                <Form.Control
                                    {...field }
                                    isInvalid={meta.touched && meta.error}
                                />
                            </Col>
                        </Form.Group>
                    )}
                </Field>

                <Field name="plkb_kontak">
                    {({field, meta}) => (
                        <Form.Group as={Row} className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                            <Form.Label column sm={7}>
                                Kontak (No HP atau Email) *
                                {meta.touched && meta.error && (
                                    <>
                                        <br />
                                        <small>* {meta.error}</small>
                                    </>
                                )}
                            </Form.Label>
                            <Col sm={5}>
                                <Form.Control
                                    {...field}
                                    isInvalid={meta.touched && meta.error}
                                />
                            </Col>
                        </Form.Group>
                    )}
                </Field>
            </Card.Body>
        </Card>
    )
}