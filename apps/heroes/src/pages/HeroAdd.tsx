import { useHeroStore } from "@src/store/heroStore";
import HeroFormContent from "../components/HeroFormContent";

function HeroAdd() {
  const addHero = useHeroStore((s) => s.heroAdd);

  return (
    <div>
      <h4>New Hero</h4>
      <HeroFormContent onSubmit={addHero} />
    </div>
  );
}

export default HeroAdd;
