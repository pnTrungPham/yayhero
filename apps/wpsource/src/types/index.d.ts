import { ReactElement, ReactNode } from "react";

import jQuery from "@types/jquery";

type WPSourceDataType =
  import("@src/common/types/localize/wpsourceData.type").WPSourceDataType;

declare global {
  // eslint-disable-next-line no-unused-vars
  interface Window {
    jQuery: typeof jQuery;
    wpsourceData: WPSourceDataType;
  }
}

export type ComponentChildren = ReactElement | ReactNode | boolean | string;
