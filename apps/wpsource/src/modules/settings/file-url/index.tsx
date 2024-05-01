import { Form, Input } from "antd";
import { useWPSourceStore } from "../../../store/wpSourceStore";

const ExtraText = () => {
  return (
    <div>
      <p>
        Default path is: <code>https://alan.ninjateam.org</code>
      </p>
    </div>
  );
};

function FileUrl() {
  const setSettingsFileUrl = useWPSourceStore(
    (state) => state.setSettingsFileUrl
  );

  const settingsFileUrl = useWPSourceStore((state) => state.settings.file_url);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSettingsFileUrl(e.target.value);
  };

  return (
    <Form.Item label="File Url" name="file-url" extra={<ExtraText />}>
      <Input
        placeholder="ex:..."
        onChange={handleChange}
        value={settingsFileUrl}
      />
    </Form.Item>
  );
}

export default FileUrl;
