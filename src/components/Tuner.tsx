import React from 'react';

import EntryForm from './EntryForm';
import TunerResults from './TunerResults';

export default function Tuner() {
    return (
        <div className="container flex w-full mx-auto">
            <EntryForm />
            <TunerResults />
        </div>
    )
}