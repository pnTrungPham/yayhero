import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import "./styles/scss/global.scss";

ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,

  document.getElementById("wpsource-app") as HTMLElement
);
