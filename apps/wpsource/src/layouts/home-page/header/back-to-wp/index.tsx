import { ArrowLeftOutlined } from "@ant-design/icons";

function BackToWP() {
  const adminURL = window.wpsourceData.urls.admin_url;
  return (
    <>
      <a href={adminURL}>
        <ArrowLeftOutlined rev={undefined} /> BACK TO DASHBOARD
      </a>
    </>
  );
}

export default BackToWP;
