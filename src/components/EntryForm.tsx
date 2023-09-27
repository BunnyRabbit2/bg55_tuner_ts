import React from 'react';

export default function EntryForm() {
    return (
        <div className="bg-base-200 grid grid-cols-2 gap-2">
            <div className="form-control w-full max-w-xs">
                <label className="label">
                    <span className="label-text">Select Tune Type</span>
                </label>
                <select className="select select-bordered">
                    <option>Circuit</option>
                    <option>Drag</option>
                    <option>Drift</option>
                    <option>Rally</option>
                    <option>Off-Road</option>
                    <option>Buggy</option>
                </select>
            </div>
        </div>
    )
}