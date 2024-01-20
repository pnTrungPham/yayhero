import React from "react";
import type { MenuProps } from "antd";
import { Breadcrumb, Layout, Menu, theme } from "antd";
import { User } from "./header";
import SlideLayout from "./sider";
import ContentLayout from "./content";

const { Header, Content, Footer, Sider } = Layout;

type MenuItem = Required<MenuProps>["items"][number];

const AppManagerLayout: React.FC = () => {
  const {
    token: { colorBgContainer },
  } = theme.useToken();

  return (
    <Layout style={{ minHeight: "100vh" }}>
      <SlideLayout />
      <Layout>
        <Header
          className="ws-header text-right px-4"
          style={{ background: colorBgContainer }}
        >
          <User />
        </Header>
        <ContentLayout />
        <Footer style={{ textAlign: "center" }}>
          WPSource ©{new Date().getFullYear()} Created by Alan
        </Footer>
      </Layout>
    </Layout>
  );
};

export default AppManagerLayout;
