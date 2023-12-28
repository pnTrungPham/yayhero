import { createHashRouter } from "react-router-dom";
import HomePage from "./pages/HomePage";

const router = createHashRouter([
  {
    path: "/",
    element: <HomePage />,
  },
  {},
]);

export default router;
