import { HERO_CLASSES } from "@src/types/heroes.type";
import {
  Button,
  Col,
  Form,
  Input,
  InputNumber,
  Radio,
  RadioChangeEvent,
  Row,
  Slider,
} from "antd";
import { useState } from "react";

function HeroFormContent() {
  const onFinish = (values: any) => {
    console.log("Success:", values);
  };
  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const [value4, setValue4] = useState<string>("");

  const onChange4 = ({ target: { value } }: RadioChangeEvent) => {
    console.log("radio4 checked", value);
    setValue4(value);
  };

  const AttributeSlider = () => {
    return (
      <Slider defaultValue={5} min={1} max={10} tooltip={{ open: true }} />
    );
  };

  const ATTRIBUTE_LABEL_SPAN = 4;

  return (
    <section>
      <Form
        name="basic"
        initialValues={{ remember: true }}
        onFinish={onFinish}
        onFinishFailed={onFinishFailed}
        autoComplete="off"
      >
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={12}>
            <Form.Item
              label="Name"
              name="name"
              rules={[{ required: true, message: "Please input hero name!" }]}
            >
              <Input />
            </Form.Item>

            <Form.Item
              name="class-radio"
              label="Class"
              rules={[{ required: true, message: "Please choose hero class!" }]}
            >
              <Radio.Group
                options={HERO_CLASSES}
                onChange={onChange4}
                value={value4}
                optionType="button"
                buttonStyle="solid"
              />
            </Form.Item>

            <Form.Item
              label="Level"
              name="level"
              rules={[{ required: true, message: "Please choose hero class!" }]}
            >
              <Form.Item noStyle>
                <InputNumber min={1} max={20} />
              </Form.Item>
            </Form.Item>
          </Col>
          <Col span={12}>
            <Form.Item
              name="strength"
              label="Strength"
              labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
            >
              <AttributeSlider />
            </Form.Item>
            <Form.Item
              name="dexterity"
              label="Dexterity"
              labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
            >
              <AttributeSlider />
            </Form.Item>
            <Form.Item
              name="intelligence"
              label="Intelligence"
              labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
            >
              <AttributeSlider />
            </Form.Item>
            <Form.Item
              name="vitality"
              label="Vitality"
              labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
            >
              <AttributeSlider />
            </Form.Item>
          </Col>
        </Row>
        <Row justify="center">
          <Button type="primary" htmlType="submit">
            Create Hero
          </Button>
        </Row>
      </Form>
    </section>
  );
}

export default HeroFormContent;
