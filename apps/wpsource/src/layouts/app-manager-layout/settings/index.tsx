import { Form } from "antd";
import {
  RootPath,
  UserRoleAccess,
  FileUrl,
  MaxUploadFile,
  Language,
  HideHtaccess,
  EnableTrash,
  SaveSettings,
} from "../../../modules/settings";

function SettingsTab() {
  return (
    <Form
      labelCol={{ span: 4 }}
      wrapperCol={{ span: 14 }}
      layout="horizontal"
      size="large"
    >
      <UserRoleAccess />
      <RootPath />
      <FileUrl />
      <MaxUploadFile />
      <Language />
      <HideHtaccess />
      <EnableTrash />
      <SaveSettings />
    </Form>
  );
}

export default SettingsTab;
