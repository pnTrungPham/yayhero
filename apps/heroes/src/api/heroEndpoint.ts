import { Hero } from "@src/types/heroes.type";
import wpEndpoint from "./wpRest";

export function getHeroes() {
  return wpEndpoint.get("heroes").json();
}

export function getHeroById(heroId: number) {
  return wpEndpoint.get(`heroes/${heroId}`).json();
}

export function postHero(payload: Hero) {
  return wpEndpoint
    .post("heroes", {
      json: payload,
    })
    .json();
}

export function patchHero(heroId: number, payload: Hero) {
  return wpEndpoint
    .patch(`heroes/${heroId}`, {
      json: payload,
    })
    .json();
}

export function delteHero(heroId: number) {
  return wpEndpoint.delete(`heroes/${heroId}`).json();
}
