import React from 'react';
import ImageUpload from './ImageUpload';
import { FieldArray, Field } from 'formik';
import { Button } from 'react-bootstrap';
import './style.css';

export default function ImageUploadList({formik}) {

    return (
        <div className="sona-container">
            <fieldset>
                <FieldArray
                    name="intervensi_gambars"
                    render={helper => (
                        <>
                            <div className="sonas sonas-fieldset">
                                {formik.values.intervensi_gambars && formik.values.intervensi_gambars.map((gambar, key) => (
                                    <Field
                                        key={key}
                                        name={`intervensi_gambars[${key}]`}
                                    >
                                        {(field) => (
                                            <ImageUpload formik={formik} helper={helper} index={key} {...field} />
                                        )}
                                    </Field>

                                ))}
                            </div>
                            <Button variant="secondary" onClick={() => helper.push({
                                base64: ``,
                                caption: ``,
                                intervensi_gambar_type_id: 1,
                            })}>
                                <i className="fas fa-image"></i>  Tambah gambar
                            </Button>
                        </>
                    )}
                >

                </FieldArray>
            </fieldset>
        </div>
    );
}