
export type Data = {
  api: {
    url: string,
    nonce: string
  }
};

export const wpsourceData = (window as any).wpsourceData as Data;
