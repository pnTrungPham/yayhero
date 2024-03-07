import DashboardOutlined from "@ant-design/icons/lib/icons/DashboardOutlined";
import { ItemType } from "antd/es/menu/hooks/useItems";
import { useMemo } from "react";
import { useNavigate } from "react-router-dom";

const ManagerMenuItems = () => {
  const navigate = useNavigate();
  const memoMenuItems: ItemType[] = useMemo(() => {
    const management: ItemType[] = [
      {
        type: "group",
        label: "Management",
        children: [
          {
            key: "dashboard",
            title: "Dashboard",
            label: "Dashboard",
            icon: <DashboardOutlined />,
            onClick: () => {
              navigate("*");
            },
          },
        ],
      },
    ];

    const services: ItemType[] = [
      {
        type: "group",
        label: "Services",
        children: [
          {
            key: "order",
            title: "Order",
            label: "Order",
            icon: <DashboardOutlined />,
            onClick: () => {
              navigate("/order");
            },
          },
        ],
      },
    ];

    const setting: ItemType[] = [
      {
        type: "group",
        label: "Settings",
        children: [
          {
            key: "setting",
            title: "Setting",
            label: "Setting",
            icon: <DashboardOutlined />,
            onClick: () => {
              navigate("/setting");
            },
          },
        ],
      },
    ];

    return [...management, ...services, ...setting];
  }, [navigate]);
  return memoMenuItems;
};

export default ManagerMenuItems;
