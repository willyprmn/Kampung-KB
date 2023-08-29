import React from 'react';
import ImageUpload from './ImageUpload';
import { FieldArray, Field } from 'formik';
import {
    Col,
    Row,
} from 'react-bootstrap';
export default function CompareUpload({formik}) {

    return (
        <div className="sona-container">
            <fieldset>
                <div className="sonas sonas-fieldset">
                    <FieldArray
                        name="intervensi_gambars"
                        render={helper => (
                            <Row>
                                {formik.values.intervensi_gambars && formik.values.intervensi_gambars.map((gambar, key) => (
                                    <Field
                                        key={key}
                                        name={`intervensi_gambars[${key}]`}
                                    >
                                        {(field) => (
                                            <Col>
                                                <ImageUpload index={key} formik={formik} helper={helper} caption={false} {...field} remove={false} />
                                            </Col>
                                        )}
                                    </Field>
                                ))}
                            </Row>
                        )}
                    >
                    </FieldArray>
                </div>
            </fieldset>
        </div>
    );
}