
import { create } from "zustand";
import { devtools } from 'zustand/middleware'
import {themeStore} from "./themeStore";
import {userStore} from "./userStore";

const useBoundStore = create(
  
    devtools( (...set) => {
      return {
        ...themeStore((set) => themeStore),
        ...userStore(...set),
      }
    },
  )
  
    
)
export default useBoundStore;
