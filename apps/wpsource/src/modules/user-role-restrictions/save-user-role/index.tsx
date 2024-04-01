import { Button, Form } from "antd";

function SaveUserRole() {
  return (
    <Form.Item label="">
      <Button type="primary" htmlType="submit" className="bg-[#1677ff]">
        Save Changes
      </Button>
    </Form.Item>
  );
}

export default SaveUserRole;
