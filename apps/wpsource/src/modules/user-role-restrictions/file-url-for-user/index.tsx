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

function FileUrlForUser() {
  return (
    <Form.Item label="File Url" name="file-url-for-user" extra={<ExtraText />}>
      <Input placeholder="ex:..." />
    </Form.Item>
  );
}

export default FileUrlForUser;
