import React from 'react';

import { tuningTypes } from './TuningCalculator';

export default function EntryForm() {
    return (
        <div className="bg-base-200 grid grid-cols-2 gap-2">
            <div className="form-control w-full max-w-xs">
                <label className="label">
                    <span className="label-text">Select Tune Type</span>
                </label>
                <select className="select select-bordered">
                    {
                        tuningTypes.map((tuningType: string, index: number) => {
                            return (
                                <option key={index}>{tuningType}</option>
                            );
                        })
                    }
                </select>
            </div>
        </div>
    )
}