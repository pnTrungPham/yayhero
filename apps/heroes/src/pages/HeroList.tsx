import { Link } from "react-router-dom";

function HeroList() {
  return (
    <div>
      <h4>Heroes</h4>
      <p>Show the list of heroes here</p>
      <Link to="/heroes/add">Add</Link>
      <Link to="/heroes/edit/123">Edit</Link>
    </div>
  );
}

export default HeroList;
