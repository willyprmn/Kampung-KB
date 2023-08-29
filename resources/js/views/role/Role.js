import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import CheckboxTree from 'react-checkbox-tree';
import 'react-checkbox-tree/lib/react-checkbox-tree.css';


function Role({menus: menuProps, permissions: menuPermissions}) {

    const transformValue = (items) => {

        return items.map(item => {

            if (item.children) {
                return {
                    ...item,
                    value: item.id,
                    icon: null,
                    children: transformValue(item.children)
                }
            } else {
                return {
                    ...item,
                    icon: null,
                    value: item.id
                }
            }
        })
    }

    const [menus] = useState(transformValue(JSON.parse(menuProps)));
    const [checked, setChecked] = useState(JSON.parse(menuPermissions));
    const [expanded, setExpanded] = useState([])
    return (
        <CheckboxTree
            nodes={menus}
            checked={checked}
            expanded={expanded}
            onCheck={setChecked}
            onExpand={setExpanded}
            iconsClass="fa5"
            name="menus"
            nameAsArray={true}
        />
    );
}



if (document.getElementById('role-component')) {
    let role = document.getElementById('role-component');
    let props = {};
    for(let i = 0; i < Object.values(role.attributes).length; i++) {
        props[role.attributes.item(i).nodeName] = role.attributes.item(i).nodeValue;
    }

    ReactDOM.render(<Role {...props} />, role);
}