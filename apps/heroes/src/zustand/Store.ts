
import { create } from "zustand";
import { devtools } from 'zustand/middleware'
import {useThemeStore} from "./themeStore";
import {useUserStore, UserState} from "./userStore";
import {ThemeState} from "./themeStore"

type Store = UserState & ThemeState


const useStore = create<Store, [["zustand/devtools", never]]>( devtools((...set) => ({
  ...useUserStore(...set),
  ...useThemeStore(...set)
})))

export default useStore