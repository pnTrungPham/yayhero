import { Form } from 'antd';
import useSettingsQueries from '../../../hooks/queries/useSettingsQueries';
import {
  EnableTrash,
  FileUrl,
  HideHtaccess,
  Language,
  MaxUploadFile,
  RootPath,
  SaveSettings,
} from '../../../modules/settings';
import { useWPSourceStore } from '../../../store/wpSourceStore';

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
      layout='horizontal'
      size='large'
      className='fw-form-settings fw-px-[20px] fw-pt-[20px]'
      labelAlign='left'
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
