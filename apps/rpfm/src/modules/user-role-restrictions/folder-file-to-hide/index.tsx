import { Form, Input } from "antd";

const ExtraText = () => {
  return (
    <div>
      <p>
        Default path is: <code>https://alan.ninjateam.org</code>
      </p>
    </div>
  );
};

function FolderFileToHide() {
  return (
    <Form.Item
      label="Enter folder or file paths that you want to Hide"
      name="folder-file-to-hide"
      extra={<ExtraText />}
    >
      <Input placeholder="ex:..." />
    </Form.Item>
  );
}

export default FolderFileToHide;
