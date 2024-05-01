import { Form, Input } from "antd";
import { useWPSourceStore } from "../../../store/wpSourceStore";

const ExtraText = () => {
  return (
    <div>
      <p>
        Default: <b>0 means unlimited upload.</b>
      </p>
    </div>
  );
};

function MaxUploadFile() {
  const setSettingsMaxUploadFile = useWPSourceStore(
    (state) => state.setSettingsMaxUploadFile
  );

  const settingsMaxUploadFile = useWPSourceStore(
    (state) => state.settings.max_upload_file
  );

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSettingsMaxUploadFile(e.target.value);
  };

  return (
    <Form.Item
      label="Max Upload File"
      name="max-upload-file"
      extra={<ExtraText />}
    >
      <Input
        type="number"
        placeholder="ex:..."
        onChange={handleChange}
        value={settingsMaxUploadFile}
      />
    </Form.Item>
  );
}

export default MaxUploadFile;
