import React from 'react';

export default function TunerResults() {
    return (
        <div className="tuner-results">
            <div className="results-secondary"><h2>GAME TYPE: YEAR MAKE MODEL</h2></div>
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
        </div>
    )
}