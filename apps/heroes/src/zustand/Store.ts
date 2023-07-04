import { create } from "zustand";
import { devtools } from "zustand/middleware";
import { useThemeStore, ThemeState } from "./themeStore";
import { useUserStore, UserState } from "./userStore";
import { useCounterStore, CounterState } from "./counterStore";
import { immer } from "zustand/middleware/immer";

type Store = UserState & ThemeState & CounterState;

const useStore = create<Store, [["zustand/immer", never], ["zustand/devtools", never]]>(
  immer(
    devtools((...set) => ({
      ...useUserStore(...set),
      ...useThemeStore(...set),
      ...useCounterStore(...set),
    }))
  )
);

export default useStore;
