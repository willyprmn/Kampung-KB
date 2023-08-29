import React from 'react';
import Radio from '../../../components/forms/Radio';
import {Field} from 'formik';
import { Card, Col, Form, Row } from 'react-bootstrap';

export default function Pokja({formik}) {

    return (
        <Card className={!formik.values.pokja_pengurusan_flag || formik.values.pokja_pengurusan_flag == 'false' ? `collapsed-card` : ``}>
            {formik.isSubmitting && (
                <div className="overlay dark">
                    <i className="fas fa-2x fa-sync-alt"></i>
                </div>
            )}
            <Field name="pokja_pengurusan_flag">
                {field => (
                    <Card.Header className={field.meta.error && field.meta.touched ? `text-danger` : null}>
                        <Card.Title>
                            Kepengurusan/Pokja Kampung KB *
                            {field.meta.touched && field.meta.error && (
                                <>
                                    <br />
                                    <small>* {field.meta.error}</small>
                                </>
                            )}
                        </Card.Title>
                        <div className="card-tools">
                            <Radio {...field} id="pokja_pengurusan_flag" />
                        </div>
                    </Card.Header>
                )}
            </Field>
            <Card.Body>
                <Field name="pokja_sk_flag">
                    {field => (
                        <Form.Group as={Row}
                            className={`${field.meta.touched && field.meta.error ? `text-danger ` : ``}mb-3`}>
                            <Form.Label column sm={9}>
                                SK Pokja Kampung KB *
                                {field.meta.touched && field.meta.error && (
                                    <>
                                        <br />
                                        <small>* {field.meta.error}</small>
                                    </>
                                )}
                            </Form.Label>
                            <Col sm={3} className={`icheck-container`}>
                                <Radio {...field} id="pokja_sk_flag" />
                            </Col>
                        </Form.Group>
                    )}
                </Field>
                <Field name="pokja_jumlah">
                    {({field, meta}) => (
                        <Form.Group as={Row}
                            className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                            <Form.Label column sm={9}>
                                Jumlah Anggota Pokja *
                                {meta.touched && meta.error && (
                                    <>
                                        <br />
                                        <small>* {meta.error}</small>
                                    </>
                                )}
                            </Form.Label>
                            <Col sm={3}>
                                <Form.Control
                                    type="number"
			            min="1"
                                    {...field}
                                    isInvalid={meta.touched && meta.error}
                                />
                            </Col>
                        </Form.Group>
                    )}
                </Field>

                <Field name="pokja_pelatihan_flag">
                    {field => (
                        <Form.Group as={Row}
                            className={`${field.meta.touched && field.meta.error ? `text-danger ` : ``}mb-3`}>
                            <Form.Label column sm={9}>
                                Pelatihan/Sosialisasi Pengelolaan Kampung KB *
                                {field.meta.touched && field.meta.error && (
                                    <>
                                        <br />
                                        <small>* {field.meta.error}</small>
                                    </>
                                )}
                            </Form.Label>
                            <Col sm={3} className={`icheck-container`}>
                                <Radio {...field} id="pokja_pelatihan_flag" />
                            </Col>
                        </Form.Group>
                    )}
                </Field>
                {formik.values.pokja_pelatihan_flag && formik.values.pokja_pelatihan_flag !== 'false'
                    ? (
                    <>

                        <Field name="pokja_jumlah_terlatih">
                            {({field, meta}) => (
                                <Form.Group as={Row}
                                    className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                    <Form.Label column sm={9}>
                                        Jumlah Anggota Pokja Terlatih *
                                        {meta.touched && meta.error && (
                                            <>
                                                <br />
                                                <small>* {meta.error}</small>
                                            </>
                                        )}
                                    </Form.Label>
                                    <Col sm={3}>
                                        <Form.Control
                                            type="number"
                                            min="1"
                                            {...field}
                                            isInvalid={meta.touched && meta.error}
                                        />
                                    </Col>
                                </Form.Group>
                            )}
                        </Field>

                        <Field name="pokja_pelatihan_desc">
                            {({field, meta}) => (
                                <Form.Group as={Row}
                                    className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                    <Form.Label column sm={7}>
                                        Detail Pelatihan/Sosialisasi Pengelolaan Kampung KB *
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
                    </>
                    )
                    : ``
                }
            </Card.Body>
        </Card>
    )
}
