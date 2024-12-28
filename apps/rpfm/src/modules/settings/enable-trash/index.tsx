import { Form, Switch } from "antd";
import { useWPSourceStore } from "../../../store/wpSourceStore";

const ExtraText = () => {
  return (
    <div>
      <p>
        After enable trash, after delete your files will go to trash folder.
      </p>
    </div>
  );
};

function EnableTrash() {
  const setSettingsEnableTrash = useWPSourceStore(
    (state) => state.setSettingsEnableTrash
  );

  const settingsEnableTrash = useWPSourceStore(
    (state) => state.settings.enable_trash
  );

  const handleChange = (e: boolean) => {
    setSettingsEnableTrash(e);
  };

  return (
    <Form.Item label="Enable Trash?" name="enable_trash" extra={<ExtraText />}>
      <Switch className="fw-bg-[#bfbfbf]" onChange={handleChange} />
    </Form.Item>
  );
}

export default EnableTrash;
