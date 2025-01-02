import React from 'react';
import { Button, Input, Space } from 'antd';
import { PlusOutlined, DeleteOutlined } from '@ant-design/icons';

const RepeaterField = ({ fields, onAdd, onRemove, onUpdate, name }) => {
    return (
        <div>
            {fields && fields.map((field, index) => (
                <Space key={index} align="baseline" style={{ display: 'flex', marginBottom: 8 }}>
                    <div>
                        <label>{`Field One ${index + 1}`}</label>
                        <Input
                            value={field.field_one}
                            onChange={(e) => onUpdate(index, 'field_one', e.target.value)}
                            name={`${name}[${index}][field_one]`} // Dynamic field name for WordPress
                        />
                    </div>
                    <div>
                        <label>{`Field Two ${index + 1}`}</label>
                        <Input
                            value={field.field_two}
                            onChange={(e) => onUpdate(index, 'field_two', e.target.value)}
                            name={`${name}[${index}][field_two]`} // Dynamic field name for WordPress
                        />
                    </div>
                    <Button
                        type="danger"
                        icon={<DeleteOutlined />}
                        onClick={() => onRemove(index)}
                    />
                </Space>
            ))}
            <Button type="dashed" onClick={onAdd} icon={<PlusOutlined />}>
                Add Field
            </Button>
        </div>
    );
};

export default RepeaterField;
