import { Form } from "antd";
import {
  UserRoleSelected,
  RootPathForUser,
  FileUrlForUser,
  FileExtensionToLock,
  FileExtensionToUpload,
  FolderFileToHide,
  DisableCommand,
  SaveUserRole,
  UserRoleAccess,
} from "../../../modules/user-role-restrictions";

function UserRoleRestrictions() {
  return (
    <Form
      labelCol={{ span: 7 }}
      wrapperCol={{ span: 14 }}
      layout="horizontal"
      size="large"
      className="fw-form-user-role-restrictions bg-[#ffffff] pt-[20px] px-[20px]"
      labelAlign="left"
      labelWrap
    >
      <UserRoleAccess />
      <UserRoleSelected />
      <DisableCommand />
      <RootPathForUser />
      <FileUrlForUser />
      <FolderFileToHide />
      <FileExtensionToLock />
      <FileExtensionToUpload />
      <SaveUserRole />
    </Form>
  );
}

export default UserRoleRestrictions;
