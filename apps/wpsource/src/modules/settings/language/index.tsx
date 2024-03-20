import { Form, Input, Select } from "antd";

function Language() {
  return (
    <Form.Item label="Language" name="language">
      <Select>
        <Select.Option value="demo">Demo</Select.Option>
      </Select>
    </Form.Item>
  );
}

export default Language;
