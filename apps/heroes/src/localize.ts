export type Data = {
  isRtl: boolean;
  restUrl: string;
  restNonce: string;
};

export const yayHeroData = (window as any).yayHeroData as Data;
