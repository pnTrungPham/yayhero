import axios from "axios";
import { yayHeroData } from "../localize";

const wpEndpoint = axios.create({
  baseURL: `${yayHeroData.restUrl}yayhero/v1`,
  timeout: 5000,
  headers: { "X-WP-Nonce": yayHeroData.restNonce },
});

export default wpEndpoint;
