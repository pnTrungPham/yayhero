import { useHeroStore } from "@src/store/heroStore";
import { Hero } from "@src/types/heroes.type";
import { getErrorMessage } from "@src/utils/common";
import { notifyError, notifySuccess } from "@src/utils/notification";
import { Button, Form, notification, Space } from "antd";
import { useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import HeroFormContent from "../components/HeroFormContent";

function HeroEdit() {
  const heroBeginEditById = useHeroStore((store) => store.heroBeginEditById);
  const updateHero = useHeroStore((store) => store.heroSubmitEdit);
  const { edittingId, edittingHero } = useHeroStore((store) => store.edit);
  const isFormLoading = useHeroStore((store) => store.mutation.isLoading);

  const params = useParams();
  const heroId = params.heroId ? parseInt(params.heroId) : null;

  const [form] = Form.useForm<Hero>();
  const navigate = useNavigate();

  useEffect(() => {
    if (heroId && heroId !== edittingId) {
      heroBeginEditById(heroId);
    }
  }, [heroId]);

  useEffect(() => {
    form.resetFields();
    form.setFieldsValue(edittingHero as Hero);
  }, [edittingHero]);

  if (heroId) {
    const onFinish = async (values: Hero) => {
      try {
        await updateHero(heroId, values);

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
            disabled={isFormLoading}
            form={form}
            initialValues={edittingHero ?? undefined}
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
