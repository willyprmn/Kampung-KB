import React, {useState, useRef} from 'react';
import {
    Button,
} from 'react-bootstrap';
export default function ImageUplad({formik, caption = true, remove = true, field, meta, helper, index}) {

    const fileRef = useRef();
    const [selectedFile, setSelectedFile] = useState();
    const [preview, setPreview] = useState();

    const handleClickUpload = () => {
        fileRef.current.click();
    }

    const handleChangePreview = event => {
        if (!event.target.files || event.target.files.length === 0) {
            setSelectedFile(undefined);
            return;
        }

        let reader = new FileReader();
        let file = event.target.files[0];
        let url = reader.readAsDataURL(file);

        reader.onload = (e) => {
            const result = reader.result
            formik.setFieldValue(`${field.name}.base64`, result);
            setPreview(result);
            setSelectedFile(file);
        }
    }

    return (
        <div className="sona">
            <img className="preview-image" src={field.value.base64 || `https://kampungkb.bkkbn.go.id/assets/images/default-intervensi.png`} alt="Preview" />
            <span className="preview-details">
                <input type="file" onChange={handleChangePreview} accept="image/*" className="hidden" ref={fileRef} />
                {caption && (
                    <>
                        <input
                            name={`${field.name}.caption`}
                            value={field.value.caption}
                            onChange={formik.handleChange}
                            className="preview-caption"
                            type="text"
                            placeholder="Caption gambar..."
                        />
                    </>
                )}
                <Button variant="primary" className={caption ? `mr-2` : `m-2`} onClick={handleClickUpload}>Pilih Gambar</Button>
                {remove && (
                    <button onClick={() => helper.remove(index)} className="deletesona btn btn-danger" type="button"><i className="fas fa-trash"></i></button>
                )}
            </span>
            {meta.touched && meta.error ? Object.entries(meta.error).map(([prop, error], key) => (
                <div key={key} style={{display: `block`}} className="invalid-feedback">* {error}</div>
            )) : ``}
        </div>
    )
}