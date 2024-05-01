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
import { useWPSourceStore } from "../../../store/wpSourceStore";
import useSettingsQueries from "../../../hooks/queries/useSettingsQueries";
import { useEffect, useMemo } from "react";

function SettingsTab() {
  useSettingsQueries({
    fetch: true,
  });

  const settings = useWPSourceStore((state) => state.settings);

  console.log(settings);

  return (
    <Form
      labelCol={{ span: 4 }}
      wrapperCol={{ span: 14 }}
      layout="horizontal"
      size="large"
      className="wps-form-settings bg-[#ffffff] pt-[20px] px-[20px]"
      labelAlign="left"
      labelWrap
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
