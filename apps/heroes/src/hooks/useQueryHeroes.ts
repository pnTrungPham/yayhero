import { getHeroes } from "@src/api/heroEndpoint";
import { yayHeroData } from "@src/localize";
import { useQuery } from "react-query";
import { STALE_TIME } from "./constants";

export default function useQueryHeroes() {
  return useQuery(["heroes"], getHeroes, {
    staleTime: STALE_TIME,
    initialData: yayHeroData.preloadHeroes,
  });
}
