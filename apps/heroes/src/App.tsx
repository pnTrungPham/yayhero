import "./App.scss";

import { RouterProvider } from "react-router-dom";
import router from "./router";
import { getHeroes } from "./api/heroEndpoint";
import { useEffect } from "react";

function App() {
  return (
    <div className="yayhero-container">
      <RouterProvider router={router} />
    </div>
  );
}

export default App;
