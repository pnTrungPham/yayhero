import { createHashRouter } from "react-router-dom";
import HeroList from "./pages/HeroList";

const router = createHashRouter([
  {
    path: "/",
    element: <HeroList />,
  },
  {},
]);

export default router;
