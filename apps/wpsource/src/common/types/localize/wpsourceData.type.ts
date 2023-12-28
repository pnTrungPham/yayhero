export type WPSourceDataType = {
  urls: {
    asset_url: string;
    vite_dynamic_base: string;
    home_url: string;
    admin_url: string;
  };
  is_rtl: boolean;
  admin_ajax: {
    nonce: string;
    url: string;
  };
  rest_path: {
    root: string;
    base: string;
    nonce: string;
  };
  i18n: {
    [key: string]: string;
  };
};
