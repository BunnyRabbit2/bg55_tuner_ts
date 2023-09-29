import React from 'react';

import { tuningTypes, gameVersions, tireCompounds, damperStiffnesses, travelTypes, driveTypes, engineLayouts } from "./TuningOptions";
import { TunerSelect } from './form_elements/TunerSelect';
import { TunerTextEntry } from './form_elements/TunerTextEntry';
import { format } from 'date-fns';

export default function EntryForm() {
    const dateNow = new Date();
    const formattedDate = format(dateNow, 'yyyy-MM-dd');
    const formattedTime = format(dateNow, 'HH:mm');

    return (
        <div className="bg-base-200 grid grid-cols-1 gap-2">
            <div className=""><p>Vehicle Data Input</p></div>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-2">
                <TunerSelect
                    labelText='Tune Type'
                    selectOptions={tuningTypes}
                />
                <TunerSelect
                    labelText='Forza Version'
                    selectOptions={gameVersions}
                    hasUppercaseOptions={true}
                />
            </div>
            <div className=""><p>Car Information</p></div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-2">
                <TunerTextEntry
                    labelText="Year"
                    placeholder={format(dateNow, 'yyyy')}
                />
                <TunerTextEntry
                    labelText="Make"
                    placeholder={formattedDate}
                />
                <TunerTextEntry
                    labelText="Model"
                    placeholder={formattedTime}
                />
            </div>
            <TunerSelect
                labelText='Tire Compound'
                selectOptions={tireCompounds}
            />
            <TunerSelect
                labelText='Damper Stiffness'
                selectOptions={damperStiffnesses}
            />
            <TunerSelect
                labelText='Travel Types'
                selectOptions={travelTypes}
            />
            <TunerSelect
                labelText='Drive Types'
                selectOptions={driveTypes}
                hasUppercaseOptions={true}
            />
            <TunerSelect
                labelText='Engine Layout'
                selectOptions={engineLayouts}
            />
        </div>
    )
}