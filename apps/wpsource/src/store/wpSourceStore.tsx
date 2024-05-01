import { create } from "zustand";
import { devtools } from "zustand/middleware";
import { immer } from "zustand/middleware/immer";

import { yayHeroData } from "../localize";
import useSettingsQueries from "../hooks/queries/useSettingsQueries";

interface IWPSourceState {
  settings: {
    isLoading: boolean;
    user_roles_to_access: string[];
    enable_trash: boolean;
    file_url: string;
    hide_htaccess: boolean;
    language: string;
    max_upload_file: string;
    root_path: string;
  };
  setSettings: (newSettings: any) => void;
  setSettingsLoading: (isLoading: boolean) => void;
  setSettingsUserRolesToAccess: (userRolesToAccess: []) => void;
  setSettingsEnableTrash: (enableTrash: boolean) => void;
  setSettingsFileUrl: (fileUrl: string) => void;
  setSettingsHideHtaccess: (hideHtaccess: boolean) => void;
  setSettingsLanguage: (language: string) => void;
  setSettingsMaxUploadFile: (maxUploadFile: string) => void;
  setSettingsRootPath: (rootPath: string) => void;
}

export const useWPSourceStore = create<
  IWPSourceState,
  [["zustand/immer", never], ["zustand/devtools", never]]
>(
  immer(
    devtools((set, get) => ({
      settings: {
        isLoading: false,
        user_roles_to_access: [],
        enable_trash: false,
        file_url: "",
        hide_htaccess: false,
        language: "",
        max_upload_file: "",
        root_path: "",
      },

      setSettings: (newSettings: any) => {
        console.log(newSettings);
        set((state) => {
          state.settings = newSettings;
        });
      },
      setSettingsLoading: (isLoading: boolean) => {
        set((state) => {
          state.settings.isLoading = isLoading;
        });
      },
      setSettingsUserRolesToAccess: (userRolesToAccess: []) => {
        set((state) => {
          state.settings.user_roles_to_access = userRolesToAccess;
        });
      },
      setSettingsEnableTrash: (enableTrash: boolean) => {
        set((state) => {
          state.settings.enable_trash = enableTrash;
        });
      },
      setSettingsFileUrl: (fileUrl: string) => {
        set((state) => {
          state.settings.file_url = fileUrl;
        });
      },
      setSettingsHideHtaccess: (hideHtaccess: boolean) => {
        set((state) => {
          state.settings.hide_htaccess = hideHtaccess;
        });
      },
      setSettingsLanguage: (language: string) => {
        set((state) => {
          state.settings.language = language;
        });
      },
      setSettingsMaxUploadFile: (maxUploadFile: string) => {
        set((state) => {
          state.settings.max_upload_file = maxUploadFile;
        });
      },
      setSettingsRootPath: (rootPath: string) => {
        set((state) => {
          state.settings.root_path = rootPath;
        });
      },
    }))
  )
);
