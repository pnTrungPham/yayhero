import { Button, Form } from "antd";

function SaveSettings() {
  return (
    <Form.Item label="">
      <Button type="primary" htmlType="submit" className="bg-[#1677ff]">
        Save Changes
      </Button>
    </Form.Item>
  );
}

export default SaveSettings;
