import { useHeroStore } from "@src/store/heroStore";
import { Hero } from "@src/types/heroes.type";
import { Button, Form, notification, Space } from "antd";
import { useNavigate, useParams } from "react-router-dom";
import HeroFormContent from "../components/HeroFormContent";

function HeroEdit() {
  const openNotification = () => {
    notification.open({
      message: "Success",
      description: "Hero updated",
      onClick: () => {
        console.log("Notification Clicked!");
      },
    });
  };

  const editHero = useHeroStore((s) => s.heroEdit);
  const { heroId } = useParams();
  const hero = useHeroStore((s) => s.heroes.find((hero) => hero.id === heroId));

  const [form] = Form.useForm<Hero>();
  const navigate = useNavigate();

  if (heroId && hero) {
    const onFinish = (values: Hero) => {
      editHero(heroId, values);

      console.log("Success:", values);
      openNotification();
      navigate(-1);
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
            form={form}
            initialValues={hero}
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
