import React, {useState} from 'react';

export default function RadioGroup({options, onChange, labelKey, name, value = null}) {

    const [state, setState] = useState(value)
    const handleChange = ({target: {value}}) => {
        onChange(value)
    }

    return (
        <div style={{display: 'block'}} className="btn-group btn-group-toggle" aria-pressed="true" data-toggle="buttons">
            {options && options.map((option, key) => (
                <label key={key} style={{margin: `0 5px`, marginBottom: `1rem`, borderRadius: `.25rem`}}
                    className={`btn radio btn-outline-primary ${value == option.id ? `active` : ``}`}>
                    <input onClick={handleChange} onChange={() => {}} checked={value == option.id} name={name} value={option.id} type="radio"></input>
                    {option.name}
                </label>
            ))}
        </div>
    )
}