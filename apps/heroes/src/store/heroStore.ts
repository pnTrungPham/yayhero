import { create } from "zustand";
import { devtools } from "zustand/middleware";
import { immer } from "zustand/middleware/immer";

import {
  deleteHero,
  getHeroById,
  getHeroes,
  patchHero,
  postHero,
} from "@src/api/heroEndpoint";
import { yayHeroData } from "../localize";
import { Hero, HeroModel } from "../types/heroes.type";

interface HeroState {
  list: {
    isLoading: boolean;
    heroes: HeroModel[];
  };
  mutation: {
    isLoading: boolean;
  };
  edit: {
    edittingId: number | null;
    edittingHero: HeroModel | null;
  };

  heroRefetch: () => Promise<void>;
  heroSubmitAdd: (hero: Hero) => Promise<number>;
  heroBeginEditById: (id: number) => Promise<void>;
  heroBeginEditByModel: (hero: HeroModel) => Promise<void>;
  heroRevalidateEditModel: (id: number) => Promise<void>;
  heroSubmitEdit: (id: number, payload: Hero) => Promise<number>;
  heroDelete: (id: number) => Promise<boolean>;
}

export const useHeroStore = create<
  HeroState,
  [["zustand/immer", never], ["zustand/devtools", never]]
>(
  immer(
    devtools((set, get) => ({
      list: {
        isLoading: false,
        heroes: yayHeroData.preloadHeroes,
      },
      mutation: {
        isLoading: false,
      },
      edit: {
        edittingId: null,
        edittingHero: null,
      },

      heroRefetch: async () => {
        console.log("refetch");
        set((state) => {
          state.list.isLoading = true;
        });

        try {
          const heroes = await getHeroes();
          set((state) => {
            state.list.heroes = heroes;
          });
        } catch (error) {
          throw error;
        } finally {
          set((state) => {
            state.list.isLoading = false;
          });
        }
      },

      heroSubmitAdd: async (hero) => {
        set((state) => {
          state.mutation.isLoading = true;
        });

        try {
          const id = await postHero(hero);
          get().heroRefetch();
          return id;
        } catch (error) {
          throw error;
        } finally {
          set((state) => {
            state.mutation.isLoading = false;
          });
        }
      },

      heroBeginEditById: async (id: number) => {
        set((state) => {
          state.mutation.isLoading = true;
        });

        // Todo
        // gan id
        set((state) => {
          state.edit.edittingId = id;
        });

        // tim trong list co model chua
        const heroInListState = get().list.heroes.find(
          (hero) => hero.id === id
        );

        // co thi gan, khong thi null
        set((state) => {
          state.edit.edittingHero = heroInListState ?? null;
        });

        // call heroRevalidateEditModel

        await get().heroRevalidateEditModel(id);

        set((state) => {
          state.mutation.isLoading = false;
        });
      },

      heroBeginEditByModel: async (hero: HeroModel) => {
        // TODO gan id vs model
        set((state) => {
          state.edit.edittingHero = hero;
          state.edit.edittingId = hero.id;
        });
        // load lai tu api
        // call heroRevalidateEditModel
        await get().heroRevalidateEditModel(hero.id);
      },

      heroRevalidateEditModel: async (id: number) => {
        // check xem id con giong ma modified khac
        set((state) => {
          state.mutation.isLoading = true;
        });
        try {
          const heroFromDb = await getHeroById(id);
          const edittingHero = get().edit.edittingHero;
          // set model moi

          if (
            !edittingHero ||
            heroFromDb.id !== edittingHero.id ||
            (heroFromDb.id === edittingHero.id &&
              heroFromDb.modified !== edittingHero.modified)
          ) {
            set((state) => {
              state.edit.edittingHero = heroFromDb;
            });
          }
        } catch (e) {
          throw e;
        }

        set((state) => {
          state.mutation.isLoading = false;
        });

        // ko thi thoi
      },

      heroSubmitEdit: async (id, payload) => {
        //TODO lam giong ham add
        set((state) => {
          state.mutation.isLoading = true;
        });

        try {
          const result = await patchHero(id, payload);

          await get().heroRefetch();

          set((state) => {
            state.edit.edittingHero =
              state.list.heroes.find((hero) => hero.id === id) ?? null;
          });

          return result;
        } catch (e) {
          throw e;
        } finally {
          set((state) => {
            state.mutation.isLoading = false;
          });
        }
      },
      heroDelete: async (id: number) => {
        set((state) => {
          state.list.isLoading = true;
        });

        try {
          const result = await deleteHero(id);
          if (result) {
            const deletedIndex = get().list.heroes.findIndex(
              (hero) => hero.id === id
            );
            set((state) => {
              if (deletedIndex > -1) {
                state.list.heroes.splice(deletedIndex, 1);
              }
            });
            return result;
          } else {
            throw new Error("Failed to delete hero!");
          }
        } catch (e) {
          throw e;
        } finally {
          set((state) => {
            state.list.isLoading = false;
          });
        }
      },
    }))
  )
);
