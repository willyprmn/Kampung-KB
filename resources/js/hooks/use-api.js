import React, {useState, useEffect} from 'react';
import axios from 'axios';

export const ACTION = {
    INDEX: 'index',
}

export const MODEL = {
    PROGRAM: 'program',
    SUMBER_DANA: 'sumber-dana',
}

export const useApi = (model) => {

    const [state, setState] = useState();
    const [action, setAction] = useState();

    const handleAction = async () => {

        switch (action.action) {
            case ACTION.INDEX:
                const response = await axios.get(`/api/${model}`, {
                    params: action?.query
                });
                setState(response.data);
                break;
        }
    }

    useEffect(() => {

        if (action?.action) {
            handleAction();
        }


        return () => {
            return false;
        }

    }, [action]);

    return [state, setAction]
}