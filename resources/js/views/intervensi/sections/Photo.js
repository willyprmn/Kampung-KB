import React, {useState, useEffect} from 'react';
import axios from 'axios';
import ImageUploadList from '../components/ImageUploadList';
import CompareUpload from '../components/CompareUpload';
import {
    Card,
    Form,
} from 'react-bootstrap';

export default function Photo({formik, intervensi}) {

    const [jenisPosts, setJenisPosts] = useState([]);

    const fetchJenisPosts = async () => {
        const response = await axios.get(`/api/jenis-post`);
        setJenisPosts(response.data.data)
    }

    const handleChangeJenisPost = ({target: {value}}) => {
        formik.setFieldValue('jenis_post_id', value);
        switch (value) {
            case '1':
                formik.setFieldValue('intervensi_gambars', [
                    {
                        base64: ``,
                        intervensi_gambar_type_id: 2
                    },
                    {
                        base64: ``,
                        intervensi_gambar_type_id: 3
                    }
                ]);
                break;
            case '2':
                formik.setFieldValue('intervensi_gambars', [{
                    base64: ``,
                    caption: ``,
                    intervensi_gambar_type_id: 1
                }]);
                break;
            default:
                formik.setFieldValue('intervensi_gambars', []);

        }
    }

    useEffect(() => {
        fetchJenisPosts();
    }, []);

    return (
        <Card>
            <Card.Header>
                <Card.Title>Step 3 - Tambahkan gambar kegiatan untuk menunjukkan keseruan dari kegiatan yang dilakukan.</Card.Title>
            </Card.Header>
            <Card.Body>
                <Form.Group>
                    <Form.Label>Jenis Post</Form.Label>
                    <Form.Control as="select"
                        name="jenis_post_id"
                        value={formik.values.jenis_post_id}
                        isInvalid={formik.touched.jenis_post_id && formik.errors.jenis_post_id}
                        onChange={handleChangeJenisPost}
                    >
                        <option value={-1} disabled>Pilih</option>
                        {jenisPosts && jenisPosts.map((jenisPost, key) => (
                            <option key={key} value={jenisPost.id}>{jenisPost.name}</option>
                        ))}
                    </Form.Control>
                </Form.Group>

                {formik.values.jenis_post_id && parseInt(formik.values.jenis_post_id) === 1
                    ? (
                        <Form.Group>
                            <Form.Label>Gambar</Form.Label>
                            <CompareUpload formik={formik} />
                        </Form.Group>
                    )
                    : (parseInt(formik.values.jenis_post_id) === 2
                        ? (
                            <Form.Group>
                                <Form.Label>Gambar</Form.Label>
                                <ImageUploadList formik={formik} />
                            </Form.Group>
                        )
                        : null
                    )
                }

                {formik.touched.jenis_post_id && formik.errors.jenis_post_id && typeof formik.errors.jenis_post_id === 'string' ? (
                    <div style={{display: `block`}} className="invalid-feedback">{formik.errors.jenis_post_id}</div>
                ) : ``}
            </Card.Body>
        </Card>
    )
}