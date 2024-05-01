import restApi from "./wpRes";

export async function getSettings() {
  const response = await restApi.get("/settings");
  return response;
}

export async function updateSettings(settings: object) {
  const response = await restApi.patch("/settings", {
    settings: settings,
  });
  return response.data;
}
