import { deleteHero } from "@src/api/heroEndpoint";
import { useMutation, useQueryClient } from "react-query";

export default function useMutationHeroDelete() {
  const queryClient = useQueryClient();

  return useMutation((id: number) => deleteHero(id), {
    onSuccess: () => {
      queryClient.invalidateQueries("heroes");
    },
  });
}
