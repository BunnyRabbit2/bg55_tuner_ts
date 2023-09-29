import React from 'react';

interface TunerSelectProps {
    labelText: string;
    selectOptions: Array<string>;
    hasUppercaseOptions?: boolean;
}

export const TunerSelect = (props: TunerSelectProps) => {
    const selectClasses = "select select-bordered" + (props.hasUppercaseOptions ? " uppercase" : " capitalize");

    return (<div className="form-control w-full">
        <label className="label">
            <span className="label-text">{props.labelText}</span>
        </label>
        <select title={props.labelText} className={selectClasses}>
            {
                props.selectOptions.map((tuningType: string, index: number) => {
                    return (
                        <option className="" key={index}>{tuningType}</option>
                    );
                })
            }
        </select>
    </div>
    )
}