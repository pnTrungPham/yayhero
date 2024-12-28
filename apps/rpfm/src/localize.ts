
export type Data = {
  api: {
    url: string,
    nonce: string
  }
};

export const rpfmData = (window as any).rpfmData as Data;
