import React, {useState} from 'react';
import {v4 as uuid} from 'uuid';


export default function Radio({field, form, disabled = false}) {

    const uid = uuid();

    const [options] = useState([
        {
            variant: `primary`,
            label: `Ada`,
            value: true,
        },
        {
            variant: `danger`,
            label: `Tidak Ada`,
            value: false,
        }
    ]);

    const parseValue = (value) => {
        if (value === 'true' || value === true) return true;
        if (value === 'false' || value === false) return false;
        return null;
    }

    const handleChange = ({currentTarget: {value}}) => {

        const bool = parseValue(value);
        form.setFieldValue(field.name, bool);
    }


    return (
        <>
            {options.map((option, key) => (
                <div key={key} className={`icheck-${option.variant} d-inline`}>
                    <input
                        name={field.name}
                        onChange={handleChange}
                        disabled={disabled}
                        value={option.value}
                        checked={parseValue(field.value) === option.value}
                        id={`${uid}-${key}`}
                        type="radio"
                    />
                    <label htmlFor={`${uid}-${key}`}>{option.label}</label>
                </div>
            ))}
        </>
    );
}