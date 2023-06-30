import { createHashRouter } from "react-router-dom";
import HeroList from "./pages/HeroList";
import BigManList from "./pages/BigManList";

const router = createHashRouter([
    {
      path: "/HeroList",
      element: <HeroList />,
    },
    {
        path: "/",
        element: <BigManList />,
      },
  ]);
  
  export default router;