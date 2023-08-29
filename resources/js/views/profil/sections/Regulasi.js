import React, {useState, useEffect} from 'react';
import axios from 'axios';
import {Card, Col, Form, Row} from 'react-bootstrap';
import {Field} from 'formik';
import Radio from '../../../components/forms/Radio';

export default function Regulasi({formik})
{

    const [regulasis, setRegulasis] = useState([]);


    const fetchRegulasis = async () => {
        const response = await axios.get(`/api/regulasi`);
        setRegulasis([...response.data.map(item => {
            return {
                ...item,
                id: item.id.toString(),
            }
        })]);
    }

    useEffect(() => {
        fetchRegulasis();
    }, []);

    return (
        <Card className={!formik.values.regulasi_flag || formik.values.regulasi_flag == 'false' ? `collapsed-card` : ``}>
            {formik.isSubmitting && (
                <div className="overlay dark">
                    <i className="fas fa-2x fa-sync-alt"></i>
                </div>
            )}
            <Field
                name="regulasi_flag"
                value={formik.values.regulasi_flag}
                onChange={formik.handleChange}
            >
                {field => (
                    <Card.Header className={field.meta.error && field.meta.touched ? `text-danger` : null}>
                        <Card.Title>
                            Regulasi dari Pemerintah Daerah *
                            {field.meta.touched && field.meta.error && (
                                <>
                                    <br />
                                    <small>* {field.meta.error}</small>
                                </>
                            )}
                        </Card.Title>
                        <div className="card-tools">
                            <Radio {...field} id="regulasi_flag" />
                        </div>
                    </Card.Header>
                )}
            </Field>


            <Card.Body>
                <Row>
                    {regulasis && regulasis.map((regulasi, key) => (
                        <Field name="regulasis" key={key}>
                            {({field, value, meta}) => (
                                <>
                                    <Col md={6}>
                                        <Form.Group>
                                            <div className="icheck-primary d-inline">
                                                <input id={`regulasi_${key}`} {...field}
                                                    value={regulasi.id} type="checkbox"
                                                    checked={field.value?.includes(regulasi.id) ?? false}
                                                />
                                                <label htmlFor={`regulasi_${key}`}>{regulasi.name}</label>
                                            </div>
                                        </Form.Group>
                                    </Col>
                                </>
                            )}
                        </Field>
                    ))}
                </Row>
            </Card.Body>

            {formik.touched.regulasis && formik.errors.regulasis && (
                <Card.Footer className="text-danger">
                    {formik.errors.regulasis}
                </Card.Footer>
            )}
        </Card>
    )
}