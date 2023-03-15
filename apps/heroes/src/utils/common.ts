import { HTTPError } from "ky";

export async function getErrorMessage(error: unknown): Promise<string> {
  if (error instanceof HTTPError) {
    const body = await error.response.json();
    console.log("body", body);
    return body.message;
  } else {
    console.log("error", error);
    return (error as Error).message;
  }
}
