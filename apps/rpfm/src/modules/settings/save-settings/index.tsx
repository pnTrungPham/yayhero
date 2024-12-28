import { Button, Form } from "antd";

import useSettingsQueries from "../../../hooks/queries/useSettingsQueries";
import { useWPSourceStore } from "../../../store/wpSourceStore";

function SaveSettings() {
  const settings = useWPSourceStore((state) => state.settings);

  const { saveSettingsMutation } = useSettingsQueries();

  const handleSave = async () => {
    const response = await saveSettingsMutation.mutateAsync(settings);

    if (response) {
      console.log("Settings updated successfully");
    }
  };

  return (
    <Form.Item label="">
      <Button
        type="primary"
        htmlType="submit"
        className="fw-bg-[#1677ff]"
        onClick={handleSave}
      >
        Save Changes
      </Button>
    </Form.Item>
  );
}

export default SaveSettings;
