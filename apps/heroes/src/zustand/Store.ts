import {create} from "zustand";
import { devtools, persist } from 'zustand/middleware'

import themeStore from "./themeStore";
import userStore from "./userStore";

let combineStores = (...set:any) => ({
  ...themeStore(...set),
  ...userStore(...set)
})

combineStores = devtools(combineStores)

export default create(combineStores)