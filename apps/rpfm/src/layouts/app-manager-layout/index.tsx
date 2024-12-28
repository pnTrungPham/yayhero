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
    <Layout className="fw-bg-[#ffffff]">
      <Tabs
        onChange={onChange}
        items={items}
        className="fw-tab-container fw-px-2.5"
      />
    </Layout>
  );
};

export default AppManagerLayout;
