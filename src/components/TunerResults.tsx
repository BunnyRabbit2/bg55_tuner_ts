import React from 'react';

interface TunerResultsProps {
    header: string;
}

export const TunerResults = (props: TunerResultsProps) => {
    // TODO: Create components for each bit needed
    // Header row: 1, 2 or 3 column. h4
    // Value row: 2 or 3 column. h5 on label. normal or alt colour

    return (
        <div className="tuner-results">
            <div className="results-secondary"><h2>{props.header}</h2></div>
            <div className="results-accent"><h3>ENGINE / DATE TIME</h3></div>
            <div className="results-secondary grid grid-cols-3">
                <div><h4>Tire Settings</h4></div>
                <div><h4>Front</h4></div>
                <div><h4>Rear</h4></div>
            </div>
            <div className="grid grid-cols-3">
                <div><p>Tire Pressure (TYPE)</p></div>
                <div><p>X psi</p></div>
                <div><p>X psi</p></div>
            </div>
            <div className="results-secondary"><h4>Gear Ratios</h4></div>
            <div className="grid grid-cols-2">
                <div><p>Final Drive</p></div>
                <div><p>X</p></div>
            </div>
            <div className="grid grid-cols-2">
                <div><p>Ratios</p></div>
                <div><p>(1) X | (2) X | (3) X | (4) X | (5) X | (6) X</p></div>
            </div>
            <div className="results-secondary grid grid-cols-3">
                <div><h4>Alignment Settings</h4></div>
                <div><h4>Front</h4></div>
                <div><h4>Rear</h4></div>
            </div>
            <div className="grid grid-cols-3">
                <div><p>Camber</p></div>
                <div><p>X</p></div>
                <div><p>X</p></div>
            </div>
            <div className="grid grid-cols-3 results-alt">
                <div><p>Toe</p></div>
                <div><p>X</p></div>
                <div><p>X</p></div>
            </div>
            <div className="grid grid-cols-2">
                <div><p>Caster</p></div>
                <div><p>X</p></div>
            </div>
            <div className="grid grid-cols-2 results-alt">
                <div><p>Steering Angle</p></div>
                <div><p>X</p></div>
            </div>
        </div>
    )
}