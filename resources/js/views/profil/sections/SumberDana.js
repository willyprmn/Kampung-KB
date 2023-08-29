import React, {useState, useEffect} from 'react';
import axios from 'axios';
import {Field} from 'formik';
import {Card, Col, Row, Form} from 'react-bootstrap';


export default function SumberDana({formik}) {

    const [sumberDanas, setSumberDanas] = useState([]);

    const fetchSumberDanas = async () => {
        const response = await axios.get(`/api/sumber-dana`);
        setSumberDanas([...response.data.map((item) => {
            return {
                ...item,
                id: item.id.toString()
            }
        })]);
    }

    useEffect(() => {
        fetchSumberDanas();
    }, []);

    return (
        <Card>
            {formik.isSubmitting && (
                <div className="overlay dark">
                    <i className="fas fa-2x fa-sync-alt"></i>
                </div>
            )}
            <Card.Header>
                <Card.Title>Sumber Dana</Card.Title>
            </Card.Header>
            <Card.Body>
                <Row>
                    {sumberDanas && sumberDanas.map((dana, key) => (
                        <Field name="sumber_danas" key={key}>
                            {({field, value, meta}) => (
                                <Col md={4}>
                                    <Form.Group>
                                        <div className="icheck-primary d-inline">
                                            <input id={`sumber_dana_${key}`} {...field}
                                                value={dana.id} type="checkbox"
                                                checked={field.value?.includes(dana.id) ?? false}
                                            />
                                            <label htmlFor={`sumber_dana_${key}`}>{dana.name}</label>
                                        </div>
                                    </Form.Group>
                                </Col>
                            )}
                        </Field>
                    ))}
                </Row>
            </Card.Body>
        </Card>
    );
}

