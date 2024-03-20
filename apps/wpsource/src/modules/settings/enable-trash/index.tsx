import { Form, Switch } from "antd";

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
  return (
    <Form.Item label="Enable Trash?" name="enable-trash" extra={<ExtraText />}>
      <Switch />
    </Form.Item>
  );
}

export default EnableTrash;
