import { ArrowLeftOutlined } from "@ant-design/icons";

function BackToWP() {
  const adminURL = window.wpsourceData.urls.admin_url;
  return (
    <>
      <a href={adminURL}>
        <ArrowLeftOutlined className="align-[1px]" rev={undefined} />
        <span> Back To Dashboard </span>
      </a>
    </>
  );
}

export default BackToWP;
