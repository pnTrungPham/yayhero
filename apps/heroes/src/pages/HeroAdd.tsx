import { Hero } from "@src/types/heroes.type";
import { getErrorMessage } from "@src/utils/common";
import { notifyError, notifySuccess } from "@src/utils/notification";
import { Button, Form, Space } from "antd";
import { useNavigate } from "react-router-dom";
import HeroFormContent from "../components/HeroFormContent";

import useMutationHeroAdd from "@src/hooks/useMutationHeroAdd";
import { yayHeroData } from "@src/localize";

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

function HeroAdd() {
  const { mutateAsync, isLoading } = useMutationHeroAdd();

  const [form] = Form.useForm<Hero>();

  const onFinish = async (values: Hero) => {
    try {
      await mutateAsync(values);
      notifySuccess({
        message: "Success",
        description: "Hero created!",
      });
      navigate(-1);
    } catch (e) {
      const msg = await getErrorMessage(e);

      notifyError({
        message: "Error",
        description: msg,
      });
    }
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const navigate = useNavigate();

  return (
    <div>
      <Space
        direction="vertical"
        size="middle"
        style={{ display: "flex", marginBottom: "20px" }}
      >
        <h4>New Hero</h4>
        <Button type="primary" onClick={() => navigate(-1)}>
          Back
        </Button>
      </Space>

      <section>
        <Form
          disabled={isLoading || !yayHeroData.auth.canWrite}
          form={form}
          initialValues={DEFAULT_VALUE}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
          autoComplete="off"
        >
          <HeroFormContent />
        </Form>
      </section>
    </div>
  );
}

export default HeroAdd;
