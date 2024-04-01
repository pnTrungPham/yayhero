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
      <Switch className="wps-hide-htaccess__switch bg-[#bfbfbf]" />
    </Form.Item>
  );
}

export default HideHtaccess;
