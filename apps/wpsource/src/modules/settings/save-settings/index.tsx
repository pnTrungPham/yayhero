import { Button, Form } from "antd";

function SaveSettings() {
  return (
    <Form.Item label="">
      <Button type="primary" htmlType="submit">
        Save Changes
      </Button>
    </Form.Item>
  );
}

export default SaveSettings;
