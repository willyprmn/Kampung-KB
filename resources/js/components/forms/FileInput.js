import React, {useState, useRef} from 'react';
import {v4 as uuid} from 'uuid';

export default function FileInput({name, value, form, accept = []}) {

    const uid = uuid();
    const uploader = useRef();
    const [filename, setFilename] = useState(form?.values?.archive?.name ?? `Choose file`);
    const [selectedFile, setSelectedFile] = useState();

    const handleChange = (event) => {
        if (!event.target.files || event.target.files.length === 0) {
            setSelectedFile(undefined);
            return;
        }

        let reader = new FileReader();
        let file = event.target.files[0];
        let url = reader.readAsDataURL(file);

        reader.onload = () => {
            setFilename(file.name);
            const result = reader.result;
            form.setFieldValue(name, file)
        }
    }

    return (
        <div className="input-group mb-3">
            <div className="custom-file">
                <input id={uid}
                    name={name}
                    ref={uploader}
                    type="file"
                    accept={accept.join(',')}
                    onChange={handleChange}
                    className="custom-file-input"

                />
                <label className="custom-file-label" htmlFor={uid}>
                    {filename}
                </label>
            </div>
            {form?.values?.archive?.id && (
                <div className="input-group-append">
                    <a href={`/archive/${form.values.archive.id}`} target="_blank" className="input-group-text">Download</a>
                </div>
            )}
        </div>
    )
}