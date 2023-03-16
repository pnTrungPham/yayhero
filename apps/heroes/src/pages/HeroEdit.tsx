import useMutationHeroUpdate from "@src/hooks/useMutationHeroUpdate";
import useQueryHero from "@src/hooks/useQueryHero";
import { Hero } from "@src/types/heroes.type";
import { getErrorMessage } from "@src/utils/common";
import { notifyError, notifySuccess } from "@src/utils/notification";
import { Button, Form, Space } from "antd";
import { useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import HeroFormContent from "../components/HeroFormContent";
import { useQueryClient } from "react-query";

function HeroEdit() {
  const params = useParams();
  const heroId = params.heroId ? parseInt(params.heroId) : null;

  const [form] = Form.useForm<Hero>();
  const navigate = useNavigate();

  const { isLoading: isSubmitLoading, mutateAsync } = useMutationHeroUpdate();

  if (heroId) {
    const { data, isLoading: isHeroLoading } = useQueryHero(heroId);

    console.log({ data });
    useEffect(() => {
      console.log("useEffect");
      form.resetFields();
      form.setFieldsValue(data as Hero);
    }, [data]);

    const onFinish = async (values: Hero) => {
      try {
        await mutateAsync({ id: heroId, hero: values });

        navigate(-1);

        notifySuccess({
          message: "Success",
          description: "Hero updated!",
        });
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

    return (
      <div>
        <Space
          direction="vertical"
          size="middle"
          style={{ display: "flex", marginBottom: "20px" }}
        >
          <h4>Edit Hero</h4>

          <Button type="primary" onClick={() => navigate(-1)}>
            Back
          </Button>
        </Space>
        <section>
          <Form
            disabled={isHeroLoading || isSubmitLoading}
            form={form}
            initialValues={data ?? undefined}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <HeroFormContent
              submitButton={{
                label: "Update",
                style: { background: "#FBC02D" },
              }}
            />
          </Form>
        </section>
      </div>
    );
  }

  return <div>Hero not found!!!</div>;
}

export default HeroEdit;
