import { Form, Switch } from "antd";
import { useWPSourceStore } from "../../../store/wpSourceStore";

const ExtraText = () => {
  return (
    <div>
      <p>Will Hide .htaccess file (if exists) in file manager. </p>
    </div>
  );
};

function HideHtaccess() {
  const setSettingsHideHtaccess = useWPSourceStore(
    (state) => state.setSettingsHideHtaccess
  );

  const settingsHideHtaccess = useWPSourceStore(
    (state) => state.settings.hide_htaccess
  );

  const handleChange = (e: boolean) => {
    setSettingsHideHtaccess(e);
  };

  return (
    <Form.Item
      label="Hide .htaccess?"
      name="hide-htaccess"
      extra={<ExtraText />}
    >
      <Switch
        className="wps-hide-htaccess__switch bg-[#bfbfbf]"
        onChange={handleChange}
        checked={Boolean(settingsHideHtaccess)}
      />
    </Form.Item>
  );
}

export default HideHtaccess;
