import { yayHeroData } from "@src/localize";
import ky from "ky";

const wpEndpoint = ky.create({
  prefixUrl: `${yayHeroData.restUrl}yayhero/v1`,
  headers: {
    "X-WP-Nonce": yayHeroData.restNonce,
  },
});

export default wpEndpoint;
