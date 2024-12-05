import { createHashRouter } from "react-router-dom";
import AppManagerLayout from "./layouts/app-manager-layout";

const router = createHashRouter([
  {
    path: "*",
    element: <AppManagerLayout />,
  },
]);

export default router;
