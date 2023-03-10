import {
  HeroClass,
  HERO_CLASSES,
  HERO_CLASS_COLORS,
} from "@src/types/heroes.type";
import { Button } from "antd";

interface HeroClassSelectorProps {
  value?: HeroClass;
  onChange?: (heroClass: HeroClass) => void;
}

function HeroClassSelector(props: HeroClassSelectorProps) {
  const { value, onChange } = props;
  const triggerChange = (changedValue: HeroClass) => {
    onChange?.(changedValue);
  };

  const getButtonStyle = (heroClass: HeroClass): React.CSSProperties => {
    if (value === heroClass) {
      return {
        color: "white",
        background: HERO_CLASS_COLORS[heroClass].activeColor ?? "transparent",
      };
    }

    return {
      background: HERO_CLASS_COLORS[heroClass].color ?? "transparent",
    };
  };

  return (
    <>
      {HERO_CLASSES.map((heroClass) => {
        return (
          <Button
            key={heroClass}
            onClick={() => triggerChange(heroClass)}
            style={getButtonStyle(heroClass)}
          >
            {heroClass}
          </Button>
        );
      })}
    </>
  );
}

export default HeroClassSelector;
