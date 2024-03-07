import React, { useState } from "react";
import { Layout, Menu } from "antd";
import { useNavigate } from "react-router-dom";
import ManagerMenuItems from "./menu-items";

const { Sider } = Layout;

const SlideLayout: React.FC = () => {
  const managerItems = ManagerMenuItems();
  const [collapsed, setCollapsed] = useState(false);
  const navigate = useNavigate();
  return (
    <Sider
      collapsible
      collapsed={collapsed}
      onCollapse={(value) => setCollapsed(value)}
    >
      <div
        className="demo-logo-vertical"
        style={{
          fontSize: "20px",
          textAlign: "center",
          background: "#646970",
          padding: "17px",
        }}
      >
        Logo
      </div>
      <Menu
        theme="dark"
        defaultSelectedKeys={["1"]}
        mode="inline"
        items={managerItems}
      />
    </Sider>
  );
};

export default SlideLayout;
