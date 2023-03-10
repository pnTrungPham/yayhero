import { create } from "zustand";
import { devtools } from "zustand/middleware";
import { immer } from "zustand/middleware/immer";

import { Hero, HeroModel, HERO_LIST } from "../types/heroes.type";

interface HeroState {
  heroes: HeroModel[];

  heroAdd: (hero: Hero) => void;
  heroEdit: (heroId: number, hero: Hero) => void;
  heroDelete: (heroId: number) => void;
}

export const useHeroStore = create<
  HeroState,
  [["zustand/immer", never], ["zustand/devtools", never]]
>(
  immer(
    devtools((set) => ({
      heroes: HERO_LIST,

      heroAdd: (hero) => {
        set((state) => {
          const heroModel: HeroModel = {
            ...hero,
            id: 1,
            modified: Date.now().toString(),
          };
          state.heroes.push(heroModel);
        });
      },

      heroEdit: (heroId, hero) => {
        set((state) => {
          const heroIndex = state.heroes.findIndex(
            (hero) => hero.id === heroId
          );
          if (heroIndex >= 0) {
            state.heroes[heroIndex] = {
              ...hero,
              id: heroId,
              modified: Date.now().toString(),
            };
          }
        });
      },

      heroDelete: (heroId) => {
        set((state) => {
          const heroIndex = state.heroes.findIndex(
            (hero) => hero.id === heroId
          );
          if (heroIndex >= 0) {
            state.heroes.splice(heroIndex, 1);
          }
        });
      },
    }))
  )
);
