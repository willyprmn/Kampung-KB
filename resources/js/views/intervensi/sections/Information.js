import React from 'react';
import ReactSummernote from 'react-summernote';
import ReactDatetime from "react-datetime";
import {
    Card,
    Form,
} from 'react-bootstrap';

import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/tooltip';

import 'react-summernote/dist/react-summernote.css';
import "react-datetime/css/react-datetime.css";
import { Field } from 'formik';

export default function Information({formik}) {

    const handleChangeTanggal = value => {
        formik.setFieldValue('tanggal', value);
    }

    const handleChangeDeskripsi = value => {
        formik.setFieldValue('deskripsi', value);
    }

    return (
        <Card>
            <Card.Header>
                <Card.Title>Step 1 - Ceritakan tentang kegiatan intervensi yang dilakukan.</Card.Title>
            </Card.Header>
            <Card.Body>
                <Form.Group>
                    <Form.Label>Judul Kegiatan *</Form.Label>
                    <Form.Control
                        name="judul"
                        value={formik.values.judul}
                        onChange={formik.handleChange}
                        isInvalid={formik.touched.judul && formik.errors.judul}
                    />
                    <Form.Control.Feedback type="invalid">
                        {formik.errors.judul}
                    </Form.Control.Feedback>
                </Form.Group>
                <Form.Group>
                    <Form.Label>Tanggal *</Form.Label>
                    <ReactDatetime
                        dateFormat="DD / MM / YYYY"
                        value={formik.values.tanggal ? formik.values.tanggal : null}
                        onChange={handleChangeTanggal}
                        timeFormat={false}
                        closeOnSelect={true}
                        renderInput={props => (
                            <>
                                <Form.Control
                                    {...props}
                                    name="tanggal"
                                    isInvalid={formik.touched.tanggal && formik.errors.tanggal}
                                />
                                <Form.Control.Feedback type="invalid">
                                    {formik.errors.tanggal}
                                </Form.Control.Feedback>
                            </>
                        )}
                    />
                </Form.Group>
                <Form.Group>
                    <Form.Label>Tempat *</Form.Label>
                    <Form.Control
                        name="tempat"
                        value={formik.values.tempat}
                        onChange={formik.handleChange}
                        isInvalid={formik.touched.tempat && formik.errors.tempat}
                    />
                    <Form.Control.Feedback type="invalid">
                        {formik.errors.tempat}
                    </Form.Control.Feedback>
                </Form.Group>
                <Field name="deskripsi">
                    {({field, meta}) => (
                        <Form.Group>
                            <Form.Label>Deskripsi *</Form.Label>
                            <ReactSummernote
                                {...field}
                                onChange={handleChangeDeskripsi}
                                options={{
                                    height: 350,
                                    dialogsInBody: true,
                                }}
                            >
                                <div dangerouslySetInnerHTML={{__html: formik.values.deskripsi}}></div>
                            </ReactSummernote>
                            <small className="text-muted">* Deskripsi ini dapat diubah</small>
                        </Form.Group>
                    )}
                </Field>
            </Card.Body>
        </Card>
    );
}