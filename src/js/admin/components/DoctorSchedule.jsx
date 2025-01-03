import React from 'react';
import { Checkbox, Button, Space, Input } from 'antd';
import { PlusOutlined, DeleteOutlined } from '@ant-design/icons';

const weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

const DoctorSchedule = ({ schedule, setSchedule, clinics }) => {
    // Toggle availability for a weekday
    const toggleAvailability = (dayIndex) => {
        const updatedSchedule = [...schedule];
        if (!updatedSchedule[dayIndex]) {
            updatedSchedule[dayIndex] = { available: false, clinics: {} };
        }
        updatedSchedule[dayIndex].available = !updatedSchedule[dayIndex].available;
        setSchedule(updatedSchedule);
    };

    // Add a new timing for a clinic
    const addTiming = (dayIndex, clinicId) => {
        const updatedSchedule = [...schedule];
        if (!updatedSchedule[dayIndex]) {
            updatedSchedule[dayIndex] = { available: false, clinics: {} };
        }
        if (!updatedSchedule[dayIndex].clinics[clinicId]) {
            updatedSchedule[dayIndex].clinics[clinicId] = [];
        }
        updatedSchedule[dayIndex].clinics[clinicId].push('');
        setSchedule(updatedSchedule);
    };

    // Update a timing for a clinic
    const updateTiming = (dayIndex, clinicId, timingIndex, value) => {
        const updatedSchedule = [...schedule];
        updatedSchedule[dayIndex].clinics[clinicId][timingIndex] = value;
        setSchedule(updatedSchedule);
    };

    // Remove a timing for a clinic
    const removeTiming = (dayIndex, clinicId, timingIndex) => {
        const updatedSchedule = [...schedule];
        updatedSchedule[dayIndex].clinics[clinicId].splice(timingIndex, 1);
        setSchedule(updatedSchedule);
    };
    console.log(schedule)
    return (
        <div>
            <h3>Doctor Schedule</h3>
            {weekDays.map((day, dayIndex) => (
                <div key={dayIndex} style={{ marginBottom: '20px' }}>
                    <Checkbox
                        checked={schedule[dayIndex]?.available || false}
                            onChange={() => toggleAvailability(dayIndex)}
                    >
                        {day}
                    </Checkbox>
                    {schedule[dayIndex]?.available && (
                        <div style={{ marginLeft: '20px' }}>
                            {clinics.map((clinic) => (
                                <div key={clinic.id} style={{ marginBottom: '10px' }}>
                                    <strong>{clinic.name}</strong>
                                    {(schedule[dayIndex].clinics[clinic.id] || []).map((timing, timingIndex) => (
                                        <Space key={timingIndex} align="baseline">
                                            <Input
                                                placeholder="Enter timing (e.g., 4:00 PM)"
                                                value={timing}
                                                onChange={(e) =>
                                                    updateTiming(dayIndex, clinic.id, timingIndex, e.target.value)
                                                }
                                                name={`schedule[${dayIndex}][clinics][${clinic.id}][${timingIndex}]`}
                                            />

                                            <Button
                                                type="danger"
                                                icon={<DeleteOutlined />}
                                                onClick={() => removeTiming(dayIndex, clinic.id, timingIndex)}
                                            />
                                        </Space>
                                    ))}
                                    <Button
                                        type="dashed"
                                        onClick={() => addTiming(dayIndex, clinic.id)}
                                        icon={<PlusOutlined />}
                                    >
                                        Add Timing
                                    </Button>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

export default DoctorSchedule;
