import { Form, Switch } from "antd";

const ExtraText = () => {
  return (
    <div>
      <p>Will Hide .htaccess file (if exists) in file manager. </p>
    </div>
  );
};

function HideHtaccess() {
  return (
    <Form.Item
      label="Hide .htaccess?"
      name="hide-htaccess"
      extra={<ExtraText />}
    >
      <Switch />
    </Form.Item>
  );
}

export default HideHtaccess;
