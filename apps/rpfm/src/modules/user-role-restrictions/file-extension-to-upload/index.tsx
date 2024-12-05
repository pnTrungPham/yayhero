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

function FileExtensionToUpload() {
  return (
    <Form.Item
      label="Enter file extensions which user can be Uploaded"
      name="file-extension-to-upload"
      extra={<ExtraText />}
    >
      <Input placeholder="ex:..." />
    </Form.Item>
  );
}

export default FileExtensionToUpload;
