import React, {useState} from 'react';
import TextInputField from "./TextInputField";
import {Form} from "antd";
import RepeaterField from "./RepeaterField";
import DoctorSchedule from "./DoctorSchedule";

const App = () => {
    const [simpleFieldOne, setSimpleFieldOne] = useState(pmwrParams.metaFields.simple_field_one || '');
    const [simpleFieldTwo, setSimpleFieldTwo] = useState(pmwrParams.metaFields.simple_field_two || '');
    const [repeaterFields, setRepeaterFields] = useState(pmwrParams.metaFields.repeater_fields || []);
    const [schedule, setSchedule] = useState(pmwrParams.metaFields.schedule || []);
    const clinics = pmwrParams.clinics || [];
    // Add a new repeater row
    const addField = () => {
        setRepeaterFields([...repeaterFields, { field_one: '', field_two: '' }]);
    };

    // Remove a repeater row
    const removeField = (index) => {
        const updatedFields = [...repeaterFields];
        updatedFields.splice(index, 1);
        setRepeaterFields(updatedFields);
    };

    // Update a repeater field
    const updateField = (index, key, value) => {
        const updatedFields = [...repeaterFields];
        updatedFields[index][key] = value;
        setRepeaterFields(updatedFields);
    };

    return (
        <>
            <TextInputField
                label="Simple Field One"
                value={simpleFieldOne}
                onChange={(e) => setSimpleFieldOne(e.target.value)}
                name="simple_field_one"
            />
            <TextInputField
                label="Simple Field Two"
                value={simpleFieldTwo}
                onChange={(e) => setSimpleFieldTwo(e.target.value)}
                name="simple_field_two"
            />

            <h3>Repeater Fields</h3>
            <RepeaterField
                fields={repeaterFields}
                onAdd={addField}
                onRemove={removeField}
                onUpdate={updateField}
                name="repeater_data"
            />
            <DoctorSchedule schedule={schedule} setSchedule={setSchedule} clinics={clinics} />
        </>
    );
};

export default App;