import { useHeroStore } from "@src/store/heroStore";
import { Button, Col, Form, Input, InputNumber, Row, Slider } from "antd";
import React from "react";
import HeroClassSelector from "./HeroClassSelector";
interface HeroFormProps {
  submitButton?: {
    label?: string;
    style?: React.CSSProperties;
  };
}

const ATTRIBUTE_LABEL_SPAN = 4;

const SLIDER_PROPS = {
  min: 1,
  max: 100,
};

function HeroFormContent(props: HeroFormProps) {
  const isFormLoading = useHeroStore((store) => store.mutation.isLoading);

  return (
    <>
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
            rules={[{ required: true, message: "Please choose hero class!" }]}
            labelCol={{ span: ATTRIBUTE_LABEL_SPAN }}
          >
            <HeroClassSelector />
          </Form.Item>

          <Form.Item
            name="level"
            label="Level"
            rules={[{ required: true, message: "Please input hero level!" }]}
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
        <Button
          loading={isFormLoading}
          type="primary"
          htmlType="submit"
          style={props.submitButton?.style}
        >
          {props.submitButton?.label ?? "Create Hero"}
        </Button>
      </Row>
    </>
  );
}

export default HeroFormContent;
