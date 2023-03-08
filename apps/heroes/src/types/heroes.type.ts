export type HeroClass = "Warrior" | "Paladin" | "Mage" | "Rogue" | "Shaman";

export interface Hero {
  name: string;
  class: HeroClass;
  level: number;
  attributes: {
    strength: number;
    dexterity: number;
    intelligence: number;
    vitality: number;
  };
}

export type HeroModel = Hero & {
  id: string;
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
    color: "",
    activeColor: "",
  },
  Paladin: {
    color: "",
    activeColor: "",
  },
  Mage: {
    color: "",
    activeColor: "",
  },
  Rogue: {
    color: "",
    activeColor: "",
  },
  Shaman: {
    color: "",
    activeColor: "",
  },
};

export const HERO_LIST: HeroModel[] = [
  {
    id: "1",
    name: "Iron Man",
    class: "Warrior",
    level: 10,
    attributes: {
      strength: 10,
      dexterity: 10,
      intelligence: 10,
      vitality: 10,
    },
  },
  {
    id: "2",
    name: "Thor",
    class: "Paladin",
    level: 10,
    attributes: {
      strength: 10,
      dexterity: 10,
      intelligence: 10,
      vitality: 10,
    },
  },
  {
    id: "3",
    name: "Black Widow",
    class: "Rogue",
    level: 5,
    attributes: {
      strength: 10,
      dexterity: 10,
      intelligence: 10,
      vitality: 10,
    },
  },
  {
    id: "4",
    name: "Scarlet Witch",
    class: "Mage",
    level: 15,
    attributes: {
      strength: 10,
      dexterity: 10,
      intelligence: 10,
      vitality: 10,
    },
  },
  {
    id: "5",
    name: "Dr. Strange",
    class: "Shaman",
    level: 10,
    attributes: {
      strength: 10,
      dexterity: 10,
      intelligence: 10,
      vitality: 10,
    },
  },
];
