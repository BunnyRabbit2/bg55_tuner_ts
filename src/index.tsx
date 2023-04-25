import React from "react";
import ReactDOM from "react-dom";

import "./app.css";

import Main from "./views/Main";

const App = () => (
    <Main />
);

ReactDOM.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>,
    document.getElementById("root")
);