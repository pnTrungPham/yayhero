import { createHashRouter } from "react-router-dom";
import AppManagerLayout from "./layouts/app-manager-layout";
import DashboardPage from "./modules/dashboard";
import StaffInfoPage from "./modules/staff-info";

const router = createHashRouter([
  {
    path: "*",
    element: <AppManagerLayout />,
    children: [
      {
        index: true,
        element: <StaffInfoPage />,
      },
      {
        path: "dashboard",
        element: <DashboardPage />,
      },
    ],
  },
]);

export default router;
