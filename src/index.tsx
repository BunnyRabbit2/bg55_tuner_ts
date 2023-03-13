import React from "react";
import ReactDOM from "react-dom";

import "./app.css";

const App = () => (
    <h1 className="app-heading">BG55 Forza Tuner</h1>
);

ReactDOM.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>,
    document.getElementById("root")
);