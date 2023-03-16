import { getHeroes, PageOptions } from "@src/api/heroEndpoint";
import { yayHeroData } from "@src/localize";
import { useQuery } from "react-query";
import { STALE_TIME } from "./constants";

export default function useQueryHeroes(pageOptions: PageOptions) {
  return useQuery(["heroes", pageOptions], () => getHeroes(pageOptions), {
    staleTime: STALE_TIME,
    initialData: () => {
      if (pageOptions.page === 1 && pageOptions.size === 5) {
        return yayHeroData.preloadHeroes;
      }
      return undefined;
    },
    keepPreviousData: true,
  });
}
