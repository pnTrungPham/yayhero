import { Layout } from "antd";
import { Content, Footer, Header } from "antd/es/layout/layout";
import { BackToWP } from "../../src/layouts/home-page/header";
import { Logo } from "../../src/layouts/home-page/header";
import { Setting } from "../layouts/home-page/header";
import "./HomePage.scss";

function HomePage() {
  return (
    <Layout>
      <Header className="ws-header">
        <BackToWP />
        <Logo />
        <Setting />
      </Header>
      <Layout>
        <Content>main content</Content>
      </Layout>
      <Footer>footer</Footer>
    </Layout>
  );
}

export default HomePage;
