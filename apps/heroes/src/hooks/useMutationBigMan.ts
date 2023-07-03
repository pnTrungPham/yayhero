import { STALE_TIME } from "./constants";
import { useMutation, useQueryClient } from "react-query";
import { addBigMan, deleteBigMan, updateBigMan } from "../api/bigManEndpoint";

export function useMutationBigMansAdd() {
  const queryClient = useQueryClient();
  return useMutation(addBigMan, {
    onSuccess: () => {
      // Refresh the user list after successful addition
      queryClient.invalidateQueries("bigman");
    },
  });
}

export function useMutationBigMansDelete() {
  const queryClient = useQueryClient();
  return useMutation(deleteBigMan, {
    onSuccess: () => {
      // Refresh the user list after successful addition
      queryClient.invalidateQueries("bigman");
    },
  });
}

export function useMutationBigMansUpdate() {
  const queryClient = useQueryClient();
  return useMutation(updateBigMan, {
    onSuccess: () => {
      // Refresh the user list after successful addition
      queryClient.invalidateQueries("bigman");
    },
  });
}
