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

function FileUrl() {
  return (
    <Form.Item label="File Url" name="file-url" extra={<ExtraText />}>
      <Input placeholder="ex:..." />
    </Form.Item>
  );
}

export default FileUrl;
