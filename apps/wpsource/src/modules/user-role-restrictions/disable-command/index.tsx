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

function DisableCommand() {
  return (
    <Form.Item
      label="Disable command"
      name="disable-command"
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

export default DisableCommand;
