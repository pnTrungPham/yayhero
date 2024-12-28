import { Form, Select } from 'antd';
import { useWPSourceStore } from '../../../store/wpSourceStore';

function Language() {
  const setSettingsLanguage = useWPSourceStore((state) => state.setSettingsLanguage);

  const settingsLanguage = useWPSourceStore((state) => state.settings.language);

  const handleChange = (e: string) => {
    setSettingsLanguage(e);
  };
  return (
    <Form.Item label='Language' name='language' className='fw-font-medium fw-uppercase'>
      <Select onChange={handleChange}>
        <Select.Option value='demo'>Demo</Select.Option>
      </Select>
    </Form.Item>
  );
}

export default Language;
