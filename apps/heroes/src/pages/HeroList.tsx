import { Link } from "react-router-dom";
import { useHeroStore } from "@src/store/heroStore";

function HeroList() {
  const heroes = useHeroStore((s) => s.heroes);

  return (
    <div>
      <h4>Heroes</h4>
      <p>Show the list of heroes here</p>
      <ul>
        {heroes.map((hero) => (
          <li key={hero.id}>{hero.name}</li>
        ))}
      </ul>
      <Link to="/heroes/add">Add</Link>
      <Link to="/heroes/edit/123">Edit</Link>
    </div>
  );
}

export default HeroList;
