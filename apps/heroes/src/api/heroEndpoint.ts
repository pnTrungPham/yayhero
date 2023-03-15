import { Hero, HeroModel } from "@src/types/heroes.type";
import wpEndpoint from "./wpRest";

export function getHeroes(): Promise<HeroModel[]> {
  return wpEndpoint.get("heroes").json();
}

export function getHeroById(heroId: number): Promise<HeroModel> {
  return wpEndpoint.get(`heroes/${heroId}`).json();
}

export function postHero(payload: Hero): Promise<number> {
  return wpEndpoint
    .post("heroes", {
      json: payload,
    })
    .json();
}

export function patchHero(heroId: number, payload: Hero): Promise<any> {
  return wpEndpoint
    .patch(`heroes/${heroId}`, {
      json: payload,
    })
    .json();
}

export function deleteHero(heroId: number): Promise<boolean> {
  return wpEndpoint.delete(`heroes/${heroId}`).json();
}
