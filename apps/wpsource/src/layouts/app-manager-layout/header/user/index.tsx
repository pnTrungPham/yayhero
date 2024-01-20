import { UserOutlined } from "@ant-design/icons";
import { Avatar } from "antd";

function User() {
  return (
    <>
      <Avatar size={32} icon={<UserOutlined />} />
    </>
  );
}

export default User;
