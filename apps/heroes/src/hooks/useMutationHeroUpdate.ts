import { patchHero } from "@src/api/heroEndpoint";
import { Hero } from "@src/types/heroes.type";
import { useMutation, useQueryClient } from "react-query";

export default function useMutationHeroUpdate() {
  const queryClient = useQueryClient();

  return useMutation(
    ({ id, hero }: { id: number; hero: Hero }) => patchHero(id, hero),
    {
      onSuccess: (_, { id }) => {
        queryClient.invalidateQueries("heroes");
        queryClient.invalidateQueries(["hero", id]);
      },
    }
  );
}
