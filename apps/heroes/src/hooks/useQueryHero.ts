import { getHeroById } from "@src/api/heroEndpoint";
import { useQuery } from "react-query";
import { STALE_TIME } from "./constants";

export default function useQueryHero(id: number) {
  return useQuery(["hero", id], () => getHeroById(id), {
    staleTime: STALE_TIME,
  });
}
