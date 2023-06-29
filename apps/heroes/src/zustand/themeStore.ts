import { StateCreator } from "zustand";

export interface ThemeState {
    dark: boolean;
    bgColor: string;
    txtColor: string
    toggleDarkMode: (isDarkMode: boolean) => void;
}

const initialState = {
    dark: false,
    bgColor: '#fff',
    txtColor: '#111'
}

export const useThemeStore:StateCreator<ThemeState> = (set) => {
    return {
        dark: initialState.dark,
        bgColor: initialState.bgColor,
        txtColor: initialState.txtColor,
        toggleDarkMode: (isDarkMode: boolean) => {
            set((state) => {
            return {
                dark: isDarkMode,
                bgColor: isDarkMode ? '#111' : '#fff',
                txtColor: isDarkMode ? '#fff' : '#111'
            }
            },
            false,
            `theme/toggle_${isDarkMode ? 'dark' : 'light'}`
            )
        }
    };
  };
