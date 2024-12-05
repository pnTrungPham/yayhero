import { Form, Select } from "antd";

const ExtraText = () => {
  return (
    <div>
      <p>Please select a User Role at Setings tab to use this option.</p>
    </div>
  );
};

function UserRoleSelected() {
  return (
    <Form.Item
      label="If User Role is"
      name="user-role-selected"
      extra={<ExtraText />}
    >
      <Select>
        <Select.Option value="demo">Demo</Select.Option>
      </Select>
    </Form.Item>
  );
}

export default UserRoleSelected;
