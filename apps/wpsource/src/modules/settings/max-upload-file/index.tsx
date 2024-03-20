import { Form, Input } from "antd";

const ExtraText = () => {
  return (
    <div>
      <p>
        Default: <b>0 means unlimited upload.</b>
      </p>
    </div>
  );
};

function MaxUploadFile() {
  return (
    <Form.Item
      label="Max Upload File"
      name="max-upload-file"
      extra={<ExtraText />}
    >
      <Input type="number" placeholder="ex:..." />
    </Form.Item>
  );
}

export default MaxUploadFile;
