import { StateCreator } from "zustand";

interface ThemeState {
    dark: boolean;
    bgColor: string;
    txtColor: string
}

const initialState:ThemeState = {
    dark: false,
    bgColor: '#fff',
    txtColor: '#111'
}

export const themeStore:StateCreator<ThemeState> = (set) => {
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
