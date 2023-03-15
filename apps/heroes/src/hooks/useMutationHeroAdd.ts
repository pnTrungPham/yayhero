import { postHero } from "@src/api/heroEndpoint";
import { Hero } from "@src/types/heroes.type";
import { useMutation, useQueryClient } from "react-query";

export default function useMutationHeroAdd() {
  const queryClient = useQueryClient();

  return useMutation((hero: Hero) => postHero(hero), {
    onSuccess: () => {
      queryClient.invalidateQueries("heroes");
    },
  });
}
