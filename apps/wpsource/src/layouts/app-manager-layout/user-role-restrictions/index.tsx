import { Form } from "antd";
import {
  UserRoleSelected,
  RootPathForUser,
  FileUrlForUser,
  FileExtensionToLock,
  FileExtensionToUpload,
  FolderFileToHide,
  DisableCommand,
} from "../../../modules/user-role-restrictions";

function UserRoleRestrictions() {
  return (
    <Form
      labelCol={{ span: 4 }}
      wrapperCol={{ span: 14 }}
      layout="horizontal"
      size="large"
    >
      <UserRoleSelected />
      <DisableCommand />
      <RootPathForUser />
      <FileUrlForUser />
      <FolderFileToHide />
      <FileExtensionToLock />
      <FileExtensionToUpload />
    </Form>
  );
}

export default UserRoleRestrictions;
