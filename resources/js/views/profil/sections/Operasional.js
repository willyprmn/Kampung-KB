import React, { useEffect, useState } from 'react';
import {Card, Col, Form, Row} from 'react-bootstrap';
import axios from 'axios';
import Radio from '../../../components/forms/Radio';
import { Field, FieldArray } from 'formik';

export default function Operasional({formik, operasionals})
{

    const [frekuensis, setFrekuensis] = useState([]);

    const fetchFrekuensis = async () => {
        const response = await axios.get(`/api/frekuensi`);
        setFrekuensis(response.data);
    }

    useEffect(() => {
        fetchFrekuensis();
    }, []);


    return (
        <FieldArray
            name="operasionals"
            render={() => operasionals && operasionals.map((operasional, key) => (
                <Card key={key}
                    className={
                        formik.values.operasionals &&
                        formik.values.operasionals[operasional.id] &&
                        formik.values.operasionals[operasional.id]?.operasional_flag
                            ? ``
                            : `collapsed-card`
                    }
                >
                    {formik.isSubmitting && (
                        <div className="overlay dark">
                            <i className="fas fa-2x fa-sync-alt"></i>
                        </div>
                    )}
                    <Field name={`operasionals.${operasional.id}.operasional_flag`}>
                        {field => (
                            <Card.Header className={field.meta.error && field.meta.touched ? `text-danger` : null}>
                                <Card.Title>
                                    {operasional.name} *
                                    {field.meta.touched && field.meta.error && (
                                        <>
                                            <br />
                                            <small>* {field.meta.error}</small>
                                        </>
                                    )}
                                </Card.Title>
                                    <div className="card-tools">
                                        <Radio {...field} id="penggunaan_data_flag" />
                                    </div>
                            </Card.Header>
                        )}
                    </Field>
                    <Card.Body>
                        <Field name={`operasionals.${operasional.id}.frekuensi_id`}>
                            {({field, meta}) => (
                                <Form.Group as={Row}
                                    className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                    <Form.Label column sm={7}>
                                        Frekuensi *
                                        {meta.touched && meta.error && (
                                            <>
                                                <br />
                                                <small>* {meta.error}</small>
                                            </>
                                        )}
                                    </Form.Label>
                                    <Col sm={5}>
                                        <Form.Control as="select"
                                            isInvalid={meta.touched && meta.error}
                                            defaultValue={-1}
                                            {...field}
                                        >
                                            <option value={-1} disabled>Pilih...</option>
                                            {frekuensis && frekuensis.map((frekuensi, key) => (
                                                <option key={key} value={frekuensi.id}>{frekuensi.name}</option>
                                            ))}
                                        </Form.Control>
                                    </Col>
                                </Form.Group>
                            )}
                        </Field>
                        {formik.values.operasionals &&
                        formik.values.operasionals[operasional.id] &&
                        formik.values.operasionals[operasional.id].frekuensi_id == 6 && (
                            <Field name={`operasionals.${operasional.id}.frekuensi_lainnya`}>
                                {({field, meta}) => (
                                    <Form.Group as={Row}
                                        className={`${meta.touched && meta.error ? `text-danger ` : ``}mb-3`}>
                                        <Form.Label column sm={7}>
                                            Frekuensi Lainnya *
                                            {meta.touched && meta.error && (
                                                <>
                                                    <br />
                                                    <small>* {meta.error}</small>
                                                </>
                                            )}
                                        </Form.Label>
                                        <Col sm={5}>
                                            <Form.Control
                                                isInvalid={meta.touched && meta.error}
                                                 {...field}
                                            />
                                        </Col>
                                    </Form.Group>
                                )}
                            </Field>
                        )}
                    </Card.Body>
                </Card>
            ))}
        />
    );
}