import { HeroModel } from "./types/heroes.type";

export type Data = {
  isRtl: boolean;
  restUrl: string;
  restNonce: string;
  preloadHeroes: HeroModel[];
};

export const yayHeroData = (window as any).yayHeroData as Data;
