import { create } from "zustand";
import { devtools } from "zustand/middleware";
import { immer } from "zustand/middleware/immer";

import { getHeroes, postHero } from "@src/api/heroEndpoint";
import { yayHeroData } from "../localize";
import { Hero, HeroModel, HERO_LIST } from "../types/heroes.type";
import { HTTPError } from "ky";

// interface HeroState {
//   heroes: HeroModel[];

//   heroAdd: (hero: Hero) => void;
//   heroEdit: (heroId: number, hero: Hero) => void;
//   heroDelete: (heroId: number) => void;
// }

// export const useHeroStore = create<
//   HeroState,
//   [["zustand/immer", never], ["zustand/devtools", never]]
// >(
//   immer(
//     devtools((set) => ({
//       heroes: HERO_LIST,

//       heroAdd: (hero) => {
//         set((state) => {
//           const heroModel: HeroModel = {
//             ...hero,
//             id: 1,
//             modified: Date.now().toString(),
//           };
//           state.heroes.push(heroModel);
//         });
//       },

//       heroEdit: (heroId, hero) => {
//         set((state) => {
//           const heroIndex = state.heroes.findIndex(
//             (hero) => hero.id === heroId
//           );
//           if (heroIndex >= 0) {
//             state.heroes[heroIndex] = {
//               ...hero,
//               id: heroId,
//               modified: Date.now().toString(),
//             };
//           }
//         });
//       },

//       heroDelete: (heroId) => {
//         set((state) => {
//           const heroIndex = state.heroes.findIndex(
//             (hero) => hero.id === heroId
//           );
//           if (heroIndex >= 0) {
//             state.heroes.splice(heroIndex, 1);
//           }
//         });
//       },
//     }))
//   )
// );

interface HeroState {
  list: {
    isLoading: boolean;
    heroes: HeroModel[];
  };
  mutation: {
    isLoading: boolean;

    edittingHero: HeroModel;
  };

  heroRefetch: () => void;
  heroAdd: (
    hero: Hero,
    callbacks?: {
      successCallback?: () => void;
      failureCallback?: () => void;
    }
  ) => void;
}

export const useHeroStore = create<
  HeroState,
  [["zustand/immer", never], ["zustand/devtools", never]]
>(
  immer(
    devtools((set) => ({
      list: {
        isLoading: false,
        heroes: yayHeroData.preloadHeroes,
      },
      mutation: {
        isLoading: false,
        edittingHero: HERO_LIST[0],
      },
      heroRefetch: async () => {
        function timeout(ms: number) {
          return new Promise((resolve) => setTimeout(resolve, ms));
        }
        set((state) => {
          state.list.isLoading = true;
        });

        await timeout(1000);

        try {
          const heroes = await getHeroes();
          set((state) => {
            state.list.heroes = heroes;
          });
        } catch (error) {
          console.error(error);
        } finally {
          set((state) => {
            state.list.isLoading = false;
          });
        }
      },
      heroAdd: async (hero, callbacks) => {
        set((state) => {
          state.mutation.isLoading = true;
        });

        try {
          await postHero(hero);
          callbacks?.successCallback?.();
        } catch (error) {
          if (error instanceof HTTPError) {
            const body = await error.response.json();
            console.log(body);
          } else {
            console.log("error", error);
          }

          callbacks?.failureCallback?.();
        }

        set((state) => {
          state.mutation.isLoading = false;
        });
      },
    }))
  )
);
