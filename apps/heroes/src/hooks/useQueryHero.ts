import { getHeroById } from "@src/api/heroEndpoint";
import { useState } from "react";
import { useQuery } from "react-query";
import { STALE_TIME } from "./constants";
import { HeroModel } from "@src/types/heroes.type";

export default function useQueryHero(id: number) {
  return useQuery(["hero", id], () => getHeroById(id), {
    staleTime: STALE_TIME,
  });
}
