import React, { useEffect } from "react";
import { Checkbox, Button, Space, TimePicker, Alert } from "antd";
import { PlusOutlined, DeleteOutlined } from "@ant-design/icons";
import dayjs from "dayjs";

const weekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

const DoctorSchedule = ({ schedule, setSchedule, clinics }) => {
    // Initialize schedule with empty data for missing days
    const normalizedSchedule = weekDays.map((day) => {
        const existingDay = schedule.find((item) => item.day === day);
        return (
            existingDay || {
                available: false,
                day,
                clinics: clinics.map((clinic) => ({
                    id: clinic.id,
                    name: clinic.name,
                    timings: [],
                })),
            }
        );
    });

    const toggleAvailability = (dayIndex) => {
        const updatedSchedule = [...normalizedSchedule];
        updatedSchedule[dayIndex].available = !updatedSchedule[dayIndex].available;
        setSchedule(updatedSchedule);
    };

    const addTiming = (dayIndex, clinicId) => {
        const updatedSchedule = [...normalizedSchedule];
        const clinic = updatedSchedule[dayIndex].clinics.find((c) => c.id === clinicId);
        if (clinic) {
            clinic.timings.push({ time: "", is_bookable: true });
        }
        setSchedule(updatedSchedule);
    };

    const updateTiming = (dayIndex, clinicId, timingIndex, field, value) => {
        const updatedSchedule = [...normalizedSchedule];
        const clinic = updatedSchedule[dayIndex].clinics.find((c) => c.id === clinicId);
        if (clinic) {
            clinic.timings[timingIndex][field] = value;
        }
        setSchedule(updatedSchedule);
    };

    const removeTiming = (dayIndex, clinicId, timingIndex) => {
        const updatedSchedule = [...normalizedSchedule];
        const clinic = updatedSchedule[dayIndex].clinics.find((c) => c.id === clinicId);
        if (clinic) {
            clinic.timings.splice(timingIndex, 1);
        }
        setSchedule(updatedSchedule);
    };

    useEffect(() => {
        const hiddenInput = document.getElementById("schedule-data");
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify(normalizedSchedule);
        }
    }, [normalizedSchedule]);

    return (
        <div>
            <h3>Time Schedule</h3>

            {clinics.length === 0 && (
                <Alert message="At least one clinic is required to add a schedule." type="info" showIcon style={{ marginBottom: "20px" }} />
            )}

            {clinics.length > 0 &&
                normalizedSchedule.map((dayData, dayIndex) => (
                    <div key={dayIndex} style={{ marginBottom: "20px" }}>
                        <Checkbox checked={dayData.available} onChange={() => toggleAvailability(dayIndex)}>
                            {dayData.day}
                        </Checkbox>
                        {dayData.available && (
                            <div style={{ marginLeft: "20px" }}>
                                {dayData.clinics.map((clinic) => (
                                    <div key={clinic.id} style={{ marginBottom: "10px" }}>
                                        <strong>{clinic.name}</strong>
                                        {clinic.timings.map((timing, timingIndex) => (
                                            <Space key={timingIndex} align="baseline" style={{ marginBottom: "8px" }}>
                                                <TimePicker
                                                    format="h:mm A"
                                                    value={timing.time ? dayjs(timing.time, "h:mm A") : null}
                                                    onChange={(time, timeString) => updateTiming(dayIndex, clinic.id, timingIndex, "time", timeString)}
                                                    placeholder="Select time"
                                                />
                                                <Checkbox
                                                    checked={timing.is_bookable}
                                                    onChange={(e) => updateTiming(dayIndex, clinic.id, timingIndex, "is_bookable", e.target.checked)}
                                                >
                                                    Bookable
                                                </Checkbox>
                                                <Button
                                                    type="danger"
                                                    icon={<DeleteOutlined />}
                                                    onClick={() => removeTiming(dayIndex, clinic.id, timingIndex)}
                                                />
                                            </Space>
                                        ))}
                                        <Button type="dashed" onClick={() => addTiming(dayIndex, clinic.id)} icon={<PlusOutlined />}>
                                            Add Timing
                                        </Button>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                ))}

            <input type="hidden" id="schedule-data" name="schedule" />
        </div>
    );
};

export default DoctorSchedule;
