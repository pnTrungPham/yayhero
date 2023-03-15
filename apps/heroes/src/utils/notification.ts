import { notification } from "antd";
import { ArgsProps } from "antd/es/notification/interface";

// type UseNotification = typeof notification.useNotification;
// type NotificationInstance = ReturnType<UseNotification>[0];
// type StaticFn = (args: ArgsProps) => void;
// export function noticeError(instance: StaticFn, args: ArgsProps) {
//   instance(args);
// }

// export function noticeSuccess(instance: StaticFn, args: ArgsProps) {
//   instance(args);
// }

const DEFAULT_SUCCESS_ARGUMENTS = {
  message: "SUCCESS",
  description: "Success",
};

const DEFAULT_ERROR_ARGUMENTS = {
  message: "ERROR",
  description: "Error",
};

export const notifySuccess = (args: ArgsProps = DEFAULT_SUCCESS_ARGUMENTS) => {
  notification.open({ ...args, type: "success" });
};

export const notifyError = (args: ArgsProps = DEFAULT_ERROR_ARGUMENTS) => {
  notification.open({ ...args, type: "error" });
};
