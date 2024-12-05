import React, { useState } from "react";
import { Layout, Tabs, theme } from "antd";
import SettingsTab from "./settings";
import UserRoleRestrictionsTab from "./user-role-restrictions";
import "./index.scss";

const AppManagerLayout: React.FC = () => {
  const [items, setItems] = useState([
    {
      key: "settings",
      label: "Settings",
      children: <SettingsTab />,
    },
    {
      key: "users-role-restrictions",
      label: "Users Role Restrictions",
      children: <UserRoleRestrictionsTab />,
    },
  ]);

  const {
    token: { colorBgContainer },
  } = theme.useToken();

  const onChange = (key: string) => {
    console.log(key);
  };

  return (
    <Layout style={{ minHeight: "100vh" }}>
      <Tabs
        onChange={onChange}
        type="card"
        items={items}
        className="wps-tab-container"
      />
    </Layout>
  );
};

export default AppManagerLayout;
