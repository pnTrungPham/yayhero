import { create } from "zustand";
import { devtools } from "zustand/middleware";
import { useThemeStore, ThemeState } from "./themeStore";
import { useUserStore, UserState } from "./userStore";
import { useCounterStore, CounterState } from "./counterStore";

type Store = UserState & ThemeState & CounterState;

const useStore = create<Store, [["zustand/devtools", never]]>(
  devtools((...set) => ({
    ...useUserStore(...set),
    ...useThemeStore(...set),
    ...useCounterStore(...set),
  }))
);

export default useStore;
