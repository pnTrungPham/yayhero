import { HeroAttributes } from "@src/types/heroes.type";
import { Tag } from "antd";

function HeroAttribute(props: { attributes: HeroAttributes }) {
  const {
    attributes: { strength, dexterity, intelligence, vitality },
  } = props;

  return (
    <div>
      <Tag color="gold" className="yayhero-table-attribute">
        Strength: {strength}
      </Tag>
      <br />

      <Tag color="error" className="yayhero-table-attribute">
        Dexterity: {dexterity}
      </Tag>
      <br />

      <Tag color="geekblue" className="yayhero-table-attribute">
        Intelligence: {intelligence}
      </Tag>
      <br />

      <Tag color="cyan" className="yayhero-table-attribute">
        Vitality: {vitality}
      </Tag>
    </div>
  );
}

export default HeroAttribute;
