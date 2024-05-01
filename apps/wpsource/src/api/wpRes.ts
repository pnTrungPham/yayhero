import axios from "axios";
import { wpsourceData } from "../localize";

const wpRes = axios.create({
  baseURL: `${wpsourceData.api.url}wp_source/v1`,
  timeout: 5000,
  headers: { "X-WP-Nonce": wpsourceData.api.nonce },
});

export default wpRes;
