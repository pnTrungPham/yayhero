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

function FileExtensionToLock() {
  return (
    <Form.Item
      label="Enter file extensions which you want to Lock"
      name="file-extension-to-lock"
      extra={<ExtraText />}
    >
      <Input placeholder="ex:..." />
    </Form.Item>
  );
}

export default FileExtensionToLock;
