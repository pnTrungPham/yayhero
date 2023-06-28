
const themeState = {
    dark: false,
    bgColor: '#fff',
    txtColor: '#111'
}

let themeStore = (set: any, get: any) => {
    return {
      themeState: themeState,
      toggleDarkMode: (isDarkMode: any) => {
        set((state: any) => {
          return {
            ...state,
            themeState: {
              ...state.themeState,
              dark: isDarkMode,
              bgColor: isDarkMode ? '#111' : '#fff',
              txtColor: isDarkMode ? '#fff' : '#111'
            }
          }
        },
        false,
        `theme/toggle_${isDarkMode ? 'dark' : 'light'}`
        )
      }
    };
  };
  

export default themeStore;