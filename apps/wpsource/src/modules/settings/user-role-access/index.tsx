import React from "react";
import { Checkbox, Form } from "antd";
import type { GetProp } from "antd";
import { useWPSourceStore } from "../../../store/wpSourceStore";

const options = [
  { label: "Apple", value: "Apple" },
  { label: "Pear", value: "Pear" },
  { label: "Orange", value: "Orange" },
];

function UserRoleAccess() {
  const setSettingsUserRoleAccess = useWPSourceStore(
    (state) => state.setSettingsUserRoleAccess
  );

  const settingsUserRoleAccess = useWPSourceStore(
    (state) => state.settings.user_role_access
  );

  const onChange: GetProp<typeof Checkbox.Group, "onChange"> = (
    checkedValues
  ) => {
    console.log("checked = ", checkedValues);
  };

  return (
    <Form.Item
      label="User Roles to access"
      name="user-roles-to-access"
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
