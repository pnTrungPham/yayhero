import React, { useEffect, useState } from "react";
import useStore from "../zustand/Store";
import { User } from "../zustand/userStore";
import Card from "../components/Card";
import UserInput from "../components/UserInput";
import { Link } from "react-router-dom";

function HeroList() {
  const [edit, setEdit] = useState<User>({
    id: null,
    firstName: "",
    image: "",
  });
  const { dark, toggleDarkMode, getUsers, data: users } = useStore();

  useEffect(() => {
    getUsers();
  }, [getUsers]);
  console.log(users);

  const handleToggleDarkMode = () => {
    toggleDarkMode(!dark);
  };

  return (
    <div>
      <Link to="/">
        <button> Big Man List</button>
      </Link>
      <header className="yayhero-herolist-title">
        <h4>Heroes</h4>
      </header>
      <div>
        <UserInput edit={edit} setUserEdit={setEdit} />
      </div>
      <div style={{ cursor: "pointer", padding: "15px" }}>
        {dark ? (
          <img
            src="https://yay-wp.test/wp-content/plugins/yayhero/apps/heroes/src/images/dark.png"
            alt="Dark"
            width={50}
            onClick={handleToggleDarkMode}
          />
        ) : (
          <img
            src="https://yay-wp.test/wp-content/plugins/yayhero/apps/heroes/src/images/light.png"
            alt="Light"
            width={50}
            onClick={handleToggleDarkMode}
          />
        )}
      </div>
      <div className="yayhero-card-container">
        {users.map((user: User) => (
          <React.Fragment key={user.id}>
            <Card user={user} setUserEdit={setEdit} />
          </React.Fragment>
        ))}
      </div>
    </div>
  );
}

export default HeroList;
