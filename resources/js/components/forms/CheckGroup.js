import React, {useState, useEffect} from 'react';


export default function CheckGroup({options = [], name, onChange, selected = []}) {

    const [checked, setChecked] = useState(selected)
    const [checks, setChecks] = useState(options);

    const handleChange = ({target: {value}}) => {

        if (!value) return;

        const id = parseInt(value);
        if (checked.includes(id)) {
            setChecked(checked.filter(item => item !== id))
        } else {
            setChecked([...checked, id]);
        }
    }

    useEffect(() => {
        setChecks(options);
    }, [options]);

    useEffect(() => {
        setChecked(selected);
    }, [selected])

    useEffect(() => {
        onChange(checked);
    }, [checked]);

    return (
        <div className="btn-checkbox-group">
            {checks && checks.map((option, key) => (
                <label key={key} style={{borderRadius: `1rem`, margin: `0 5px 1rem`}}
                    className={`btn checkbox btn-outline-primary ${checked.includes(option.id) ? ` active` : ``}`}>
                    <input onChange={handleChange} checked={checked.includes(option.id)} value={option.id} type="checkbox" name={name} style={{display: 'none'}} />
                    {option.name}
                </label>
            ))}
        </div>
    )
}