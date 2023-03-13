import React from "react";
import ReactDOM from "react-dom";

import "./app.css";

const App = () => (
    <h1 className="bg-slate-100 rounded-xl p-8 dark:bg-slate-800">BG55 Forza Tuner</h1>
);

ReactDOM.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>,
    document.getElementById("root")
);