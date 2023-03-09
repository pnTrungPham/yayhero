import { Hero, HERO_CLASSES } from "@src/types/heroes.type";
import {
  Button,
  Col,
  Form,
  Input,
  InputNumber,
  notification,
  Radio,
  Row,
  Slider,
} from "antd";
import type { NotificationPlacement } from "antd/es/notification/interface";
import React, { useMemo } from "react";
interface HeroFormProps {
  onSubmit: (hero: Hero) => void;
  submitButton?: {
    label?: string;
    style?: React.CSSProperties;
  };
}

const DEFAULT_VALUE: Hero = {
  name: "default",
  class: "Mage",
  level: 1,
  attributes: {
    strength: 10,
    dexterity: 10,
    intelligence: 10,
    vitality: 10,
  },
};

const ATTRIBUTE_LABEL_SPAN = 4;

const SLIDER_PROPS = {
  min: 1,
  max: 100,
  tooltip: { open: true },
};

const Context = React.createContext({ name: "Default" });

function HeroFormContent(props: HeroFormProps) {
  const [api, contextHolder] = notification.useNotification();

  const openNotification = (placement: NotificationPlacement) => {
    api.info({
      message: `Notification ${placement}`,
      description: (
        <Context.Consumer>{({ name }) => `Hello, ${name}!`}</Context.Consumer>
      ),
      placement,
    });
  };

  const contextValue = useMemo(() => ({ name: "Ant Design" }), []);

  const [form] = Form.useForm<Hero>();

  const onFinish = (values: Hero) => {
    props.onSubmit(values);

    console.log("Success:", values);

    openNotification("topRight");
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onAttributeSliderChange = (value: number, attributeName: string) => {
    form.setFieldsValue({ attributes: { [attributeName]: value } });
  };

  return (
    <Context.Provider value={contextValue}>
      {contextHolder}
      <section>
        <Form
          form={form}
          initialValues={DEFAULT_VALUE}
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
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <Input />
              </Form.Item>

              <Form.Item
                name="class"
                label="Class"
                rules={[
                  { required: true, message: "Please choose hero class!" },
                ]}
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <Radio.Group
                  options={HERO_CLASSES}
                  optionType="button"
                  buttonStyle="solid"
                />
              </Form.Item>

              <Form.Item
                name="level"
                label="Level"
                rules={[
                  { required: true, message: "Please input hero level!" },
                ]}
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <InputNumber min={1} max={20} />
              </Form.Item>
            </Col>
            <Col span={12}>
              <Form.Item
                name={["attributes", "strength"]}
                label="Strength"
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <Slider {...SLIDER_PROPS} />
              </Form.Item>
              <Form.Item
                name={["attributes", "dexterity"]}
                label="Dexterity"
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <Slider {...SLIDER_PROPS} />
              </Form.Item>
              <Form.Item
                name={["attributes", "intelligence"]}
                label="Intelligence"
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <Slider {...SLIDER_PROPS} />
              </Form.Item>
              <Form.Item
                name={["attributes", "vitality"]}
                label="Vitality"
                labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
              >
                <Slider {...SLIDER_PROPS} />
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
    </Context.Provider>
  );
}

export default HeroFormContent;
