import { STALE_TIME } from "./constants";
import { useQuery } from "react-query";
import { getBigMans } from "../api/bigManEndpoint";

export function useQueryBigMans() {
  return useQuery(["bigman"], () => getBigMans(), {
    staleTime: STALE_TIME,
    keepPreviousData: true,
    retry: 5,
    retryDelay: 3000,
  });
}
