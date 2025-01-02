import React from 'react';
import { Form, Input } from 'antd';

const TextInputField = ({ label, value, onChange, name }) => {
    return (
        <Form.Item label={label}>
            <Input value={value} onChange={onChange} name={name} />
        </Form.Item>
    );
};

export default TextInputField;