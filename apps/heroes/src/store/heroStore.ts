import { create, StateCreator } from "zustand";
import { devtools } from "zustand/middleware";
import { immer } from "zustand/middleware/immer";

import { Hero, HeroModel, HERO_LIST } from "../types/heroes.type";

interface HeroState {
  heroes: HeroModel[];
  heroAdd: (hero: Hero) => void;
  heroEdit: (heroId: string, hero: Hero) => void;
  heroDelete: (heroId: string) => void;
}

export const useHeroStore = create<
  HeroState,
  [["zustand/immer", never], ["zustand/devtools", never]]
>(
  immer(
    devtools((set) => ({
      heroes: HERO_LIST,
      heroAdd: (hero) => {},
      heroEdit: (heroId, hero) => {},
      heroDelete: (heroId) => {},
    }))
  )
);
