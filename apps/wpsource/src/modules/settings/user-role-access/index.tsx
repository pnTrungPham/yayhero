import React from "react";
import { Checkbox, Form } from "antd";
import type { GetProp } from "antd";

const onChange: GetProp<typeof Checkbox.Group, "onChange"> = (
  checkedValues
) => {
  console.log("checked = ", checkedValues);
};

const options = [
  { label: "Apple", value: "Apple" },
  { label: "Pear", value: "Pear" },
  { label: "Orange", value: "Orange" },
];

function UserRoleAccess() {
  return (
    <Form.Item
      label="User Roles to access"
      name="disabled"
      valuePropName="checked"
    >
      <Checkbox.Group
        options={options}
        defaultValue={["Pear"]}
        onChange={onChange}
      />
    </Form.Item>
  );
}

export default UserRoleAccess;
