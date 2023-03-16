import { HeroModel, Page } from "./types/heroes.type";

export type Data = {
  isRtl: boolean;
  restUrl: string;
  restNonce: string;
  preloadHeroes: Page<HeroModel>;
  auth: {
    canRead: boolean;
    canWrite: boolean;
  };
};

export const yayHeroData = (window as any).yayHeroData as Data;
