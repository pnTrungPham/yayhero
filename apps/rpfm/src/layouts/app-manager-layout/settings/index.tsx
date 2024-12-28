import { Form } from "antd";
import {
  RootPath,
  FileUrl,
  MaxUploadFile,
  Language,
  HideHtaccess,
  EnableTrash,
  SaveSettings,
} from "../../../modules/settings";
import useSettingsQueries from "../../../hooks/queries/useSettingsQueries";
import { useWPSourceStore } from "../../../store/wpSourceStore";
import { useMemo } from "react";

function SettingsTab() {
  useSettingsQueries({ fetch: true });
  const settings = useWPSourceStore((state) => state.settings);
  const isLoading = useWPSourceStore((state) => state.isLoading);
  console.log(isLoading);
  if (isLoading) {
    return <div>Loading...</div>;
  }
  return (
    <Form
      labelCol={{ span: 4 }}
      wrapperCol={{ span: 14 }}
      layout="horizontal"
      size="large"
      className="wps-form-settings bg-[#ffffff] pt-[20px] px-[20px]"
      labelAlign="left"
      labelWrap
      initialValues={settings}
    >
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
