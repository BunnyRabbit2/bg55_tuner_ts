import React from 'react';

import EntryForm from './EntryForm';
import { TunerResults } from './TunerResults';

export default function Tuner() {
    return (
        <div className="container grid grid-cols-1 md:grid-cols-2 gap-2 w-full mx-auto">
            <EntryForm />
            <TunerResults
            header='GAME TYPE: YEAR MAKE MODEL' />
        </div>
    )
}