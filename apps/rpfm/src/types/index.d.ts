import { ReactElement, ReactNode } from "react";

import jQuery from "@types/jquery";

type rpfmDataType =
  import("@src/common/types/localize/rpfmData.type").rpfmDataType;

declare global {
  // eslint-disable-next-line no-unused-vars
  interface Window {
    jQuery: typeof jQuery;
    rpfmData: rpfmDataType;
  }
}

export type ComponentChildren = ReactElement | ReactNode | boolean | string;
