import React, {useState, useEffect} from 'react';
import axios from 'axios';
import { FieldArray, Field } from 'formik';
import Radio from '../../../components/forms/Radio';
import {
    Card,
    Col,
    Form,
    Row,
} from 'react-bootstrap';

export default function Poktan({formik, programs}) {

    return (
        <Card>
            {formik.isSubmitting && (
                <div className="overlay dark">
                    <i className="fas fa-2x fa-sync-alt"></i>
                </div>
            )}
            <Card.Header>
                <Card.Title>Profil Kepemilikan</Card.Title>
            </Card.Header>
            <Card.Body>
                <FieldArray
                    name="programs"
                    render={() => programs && programs.map((program, key) => (
                        <Field key={key} name={`programs.${program.id}.program_flag`}>
                            {field => (
                                <Form.Group as={Row}
                                    className={`${field.meta.touched && field.meta.error ? `text-danger ` : ``}mb-3`}
                                >
                                    <Form.Label column sm={9}>
                                        {program.deskripsi} *
                                        {field.meta.touched && field.meta.error && (
                                            <>
                                                <br />
                                                <small>* {field.meta.error}</small>
                                            </>
                                        )}
                                    </Form.Label>
                                    <Col sm={3} className={`icheck-container`}>
                                        <Radio {...field} id={program.id} />
                                    </Col>
                                </Form.Group>
                            )}
                        </Field>
                    ))}
                />
            </Card.Body>
        </Card>

    );
}