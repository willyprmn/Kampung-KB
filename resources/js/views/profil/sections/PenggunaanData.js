import React, {useState, useEffect} from 'react';
import {Field} from 'formik';
import {Card, Col, Form, Row} from 'react-bootstrap';
import Radio from '../../../components/forms/Radio';
import FileInput from '../../../components/forms/FileInput';
import Axios from 'axios';


export default function PenggunaanData({formik, rkmAllowedExt}) {

    const [penggunaanDatas, setPenggunaanDatas] = useState([]);

    const fetchPenggunaanDatas = async () => {
        const response = await Axios.get(`/api/penggunaan-data`);
        setPenggunaanDatas([...response.data.map(item => {
            return {
                ...item,
                id: item.id.toString()
            }
        })]);
    }

    useEffect(() => {

        if (formik.values.rencana_kerja_masyarakat_flag)
        switch (true) {
            case formik.values.rencana_kerja_masyarakat_flag === undefined:
            case formik.values.rencana_kerja_masyarakat_flag === null:
                formik.setFieldValue('penggunaan_data_flag', null);
                break;
            case formik.values.rencana_kerja_masyarakat_flag == 'false':
                formik.setFieldValue('penggunaan_data_flag', false);
                break;
        }

    }, [formik.values.rencana_kerja_masyarakat_flag]);

    useEffect(() => {
        fetchPenggunaanDatas();
    }, []);

    return (
        <>
            <Card className={!formik.values.rencana_kerja_masyarakat_flag || formik.values.rencana_kerja_masyarakat_flag == 'false' ? `collapsed-card` : ``}>
                {formik.isSubmitting && (
                    <div className="overlay dark">
                        <i className="fas fa-2x fa-sync-alt"></i>
                    </div>
                )}
                <Field
                    name="rencana_kerja_masyarakat_flag"
                    value={formik.values.rencana_kerja_masyarakat_flag}
                    onChange={formik.handleChange}
                >
                    {field => (
                        <Card.Header className={field.meta.error && field.meta.touched ? `text-danger` : null}>
                            <Card.Title>
                                Rencana Kegiatan Masyarakat *
                                {field.meta.touched && field.meta.error && (
                                    <>
                                        <br />
                                        <small>* {field.meta.error}</small>
                                    </>
                                )}
                            </Card.Title>
                            <div className="card-tools">
                                <Radio {...field} id="rencana_kerja_masyarakat_flag" />
                            </div>
                        </Card.Header>
                    )}
                </Field>
                <Card.Body>
                    <Field name="rkm">
                        {({field, meta, form}) => (
                            <Form.Group
                                className={`${form.submitCount > 0 && meta.error ? `text-danger ` : ``}mb-3`}
                                controlId="formFile" as={Row}
                            >
                                <Form.Label column sm={4}>
                                    File Rencana Kegiatan *
                                    {form.submitCount > 0 && meta.error && (
                                        <>
                                            <br />
                                            <small>* {meta.error}</small>
                                        </>
                                    )}
                                </Form.Label>
                                <Col sm={8}>
                                    <FileInput
                                        form={form}
                                        accept={rkmAllowedExt}
                                        {...field}
                                    />
                                </Col>
                            </Form.Group>
                        )}
                    </Field>
                    <Field name="penggunaan_data_flag">
                        {field => (
                            <Form.Group as={Row}
                                className={`${field.meta.touched && field.meta.error ? `text-danger ` : ``}mb-3`}>
                                <Form.Label column sm={9}>
                                    Penggunaan Data Dalam Perencanaan dan Evaluasi Kegiatan *
                                    {field.meta.touched && field.meta.error && (
                                        <>
                                            <br />
                                            <small>* {field.meta.error}</small>
                                        </>
                                    )}
                                </Form.Label>
                                <Col sm={3} className={`icheck-container`}>
                                    <Radio {...field} id="penggunaan_data_flag" />
                                </Col>
                            </Form.Group>
                        )}
                    </Field>

                    {formik.values.penggunaan_data_flag && formik.values.penggunaan_data_flag !== 'false'
                        ? (
                            <Row>
                                {penggunaanDatas && penggunaanDatas.map((penggunaaanData, key) => (
                                    <Field name="penggunaan_datas" key={key}>
                                        {({field, value, meta}) => (
                                            <Col md={6}>
                                                <Form.Group>
                                                    <div className="icheck-primary d-inline">
                                                        <input id={`penggunaan_data_${key}`} {...field}
                                                            value={penggunaaanData.id} type="checkbox"
                                                            checked={field.value?.includes(penggunaaanData.id) ?? false}
                                                        />
                                                        <label htmlFor={`penggunaan_data_${key}`}>{penggunaaanData.name}</label>
                                                    </div>
                                                </Form.Group>
                                            </Col>
                                        )}
                                    </Field>
                                ))}
                            </Row>
                        )
                        : ``
                    }
                </Card.Body>
                {formik.touched.penggunaan_datas && formik.errors.penggunaan_datas && (
                    <Card.Footer className={`text-danger`}>
                        {formik.errors.penggunaan_datas}
                    </Card.Footer>
                )}
            </Card>
        </>
    )
}