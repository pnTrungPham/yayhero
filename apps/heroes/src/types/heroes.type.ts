export type HeroClass = "Warrior" | "Paladin" | "Mage" | "Rogue" | "Shaman";

export const HERO_CLASSES: Array<HeroClass> = [
  "Warrior",
  "Paladin",
  "Mage",
  "Rogue",
  "Shaman",
];

export interface Hero {
  name: string;
  class: HeroClass;
  level: number;
  attributes: HeroAttributes;
}

export interface HeroAttributes {
  strength: number;
  dexterity: number;
  intelligence: number;
  vitality: number;
}

export type HeroModel = Hero & {
  id: number;
  modified: string;
};

type HeroClassColors = Record<
  HeroClass,
  {
    color: string;
    activeColor: string;
  }
>;


export const HERO_CLASS_COLORS: HeroClassColors = {
  Warrior: {
    color: "#FFEBEE",
    activeColor: "#EF9A9A",
  },
  Paladin: {
    color: "#F3E5F5",
    activeColor: "#CE93D8",
  },
  Mage: {
    color: "#E8EAF6",
    activeColor: "#9FA8DA",
  },
  Rogue: {
    color: "#E0F7FA",
    activeColor: "#80DEEA",
  },
  Shaman: {
    color: "#FFF8E1",
    activeColor: "#FFE082",
  },
};

export const HERO_LIST: HeroModel[] = [
  // {
  //   id: "1",
  //   name: "Iron Man",
  //   class: "Warrior",
  //   level: 10,
  //   attributes: {
  //     strength: 10,
  //     dexterity: 10,
  //     intelligence: 10,
  //     vitality: 10,
  //   },
  // },
  // {
  //   id: "2",
  //   name: "Thor",
  //   class: "Paladin",
  //   level: 10,
  //   attributes: {
  //     strength: 10,
  //     dexterity: 10,
  //     intelligence: 10,
  //     vitality: 10,
  //   },
  // },
  // {
  //   id: "3",
  //   name: "Black Widow",
  //   class: "Rogue",
  //   level: 5,
  //   attributes: {
  //     strength: 10,
  //     dexterity: 10,
  //     intelligence: 10,
  //     vitality: 10,
  //   },
  // },
  // {
  //   id: "4",
  //   name: "Scarlet Witch",
  //   class: "Mage",
  //   level: 15,
  //   attributes: {
  //     strength: 10,
  //     dexterity: 10,
  //     intelligence: 10,
  //     vitality: 10,
  //   },
  // },
  // {
  //   id: "5",
  //   name: "Dr. Strange",
  //   class: "Shaman",
  //   level: 10,
  //   attributes: {
  //     strength: 10,
  //     dexterity: 10,
  //     intelligence: 10,
  //     vitality: 10,
  //   },
  // },
];
