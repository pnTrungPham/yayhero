import { levelupHero } from "@src/api/heroEndpoint";
import { useMutation, useQueryClient } from "react-query";

export default function useMutationHeroLevelUp() {
  const queryClient = useQueryClient();

  return useMutation((id: number) => levelupHero(id), {
    onSuccess: (_, id) => {
      queryClient.invalidateQueries("heroes");
      queryClient.invalidateQueries(["hero", id]);
    },
  });
}
