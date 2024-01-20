import { createHashRouter } from "react-router-dom";
import HomePage from "./pages/HomePage";
import AppManagerLayout from "./layouts/app-manager-layout";

const router = createHashRouter([
  {
    path: "*",
    element: <AppManagerLayout />,
    children: [
      // {
      //   path: "home-page",
      //   element: <HomePage />,
      // },
    ],
  },
]);

export default router;
