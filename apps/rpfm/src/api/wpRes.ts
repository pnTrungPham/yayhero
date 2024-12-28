import axios from "axios";
import { rpfmData } from "../localize";

const wpRes = axios.create({
  baseURL: `${rpfmData.api.url}wp_source/v1`,
  timeout: 5000,
  headers: { "X-WP-Nonce": rpfmData.api.nonce },
});

export default wpRes;
