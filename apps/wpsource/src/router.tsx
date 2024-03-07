import { createHashRouter } from "react-router-dom";
import AppManagerLayout from "./layouts/app-manager-layout";
import DashboardPage from "./modules/dashboard";
import { Order } from "./modules/services";

const router = createHashRouter([
  {
    path: "*",
    element: <AppManagerLayout />,
    children: [
      {
        index: true,
        element: <DashboardPage />,
      },
      {
        path: "*",
        element: <DashboardPage />,
      },
      {
        path: "order",
        element: <Order />,
      },
    ],
  },
]);

export default router;
