import React from 'react';

interface TunerTextEntryProps {
    labelText: string;
    placeholder: string;
}

export const TunerTextEntry = (props: TunerTextEntryProps) => {
    return (<div className="form-control w-full">
        <label className="label">
            <span className="label-text">{props.labelText}</span>
        </label>
        <input type="text" placeholder={props.placeholder} className="input input-bordered w-full max-w-xs" />
    </div>
    )
}