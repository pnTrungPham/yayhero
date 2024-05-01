import { Form, Select } from "antd";
import { useWPSourceStore } from "../../../store/wpSourceStore";

function Language() {
  const setSettingsLanguage = useWPSourceStore(
    (state) => state.setSettingsLanguage
  );

  const settingsLanguage = useWPSourceStore((state) => state.settings.language);

  const handleChange = (e: string) => {
    setSettingsLanguage(e);
  };
  return (
    <Form.Item label="Language" name="language">
      <Select onChange={handleChange} value={settingsLanguage}>
        <Select.Option value="demo">Demo</Select.Option>
      </Select>
    </Form.Item>
  );
}

export default Language;
