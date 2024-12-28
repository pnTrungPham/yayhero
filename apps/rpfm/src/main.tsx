import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import "./styles/scss/global.scss";

ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,

  document.getElementById("rpfm-app") as HTMLElement
);
