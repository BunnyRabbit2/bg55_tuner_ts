import React from 'react';

export default function TunerResults() {
    return (
        <div className="bg-base-200 tuner-results">
            <div className="bg-secondary text-secondary-content font-bold text-2xl"><h2>GAME TYPE: YEAR MAKE MODEL</h2></div>
            <div className="bg-accent text-accent-content font-semibold text-xl"><h3>ENGINE / DATE TIME</h3></div>
            <div className="bg-secondary text-secondary-content grid grid-cols-3">
                <div className=""><h4>Tire Settings</h4></div>
                <div><h4>Front</h4></div>
                <div><h4>Rear</h4></div>
            </div>
            <div className="grid grid-cols-3">
                <div><p>Tire Pressure (TYPE)</p></div>
                <div><p>X psi</p></div>
                <div><p>X psi</p></div>
            </div>
            <div className="bg-secondary text-secondary-content"><h4>Gear Ratios</h4></div>
        </div>
    )
}