import AddBigManForm from "../components/AddBigManForm";
import useStore from "../zustand/Store";
import { Link } from "react-router-dom";
import { useQueryBigMans } from "../hooks/useQueryBigMan";
import { useMutationBigMansDelete } from "../hooks/useMutationBigMan";
import { useState } from "react";
import { BigMan } from "../types/bigMan.type";

const BigManList = () => {
  const [editBigMan, setEditBigMan] = useState<BigMan>({
    id: 0,
    username: "",
    age: undefined,
  });

  const { data: users, isLoading, isError, error } = useQueryBigMans();

  const { count, increment } = useStore();
  const deleteUserMutation = useMutationBigMansDelete();

  const handleUserDelete = (event: React.FormEvent, id: number) => {
    event.preventDefault();
    deleteUserMutation.mutate(id);
  };

  const handleUserEdit = (event: React.FormEvent, bigMan: BigMan) => {
    event.preventDefault();
    setEditBigMan(bigMan);
  };

  if (isLoading) {
    return <div>Loading users...</div>;
  }

  if (isError) {
    return <div>Error: {error?.message}</div>;
  }

  return (
    <div>
      <Link to="/heroes">
        <button> Heroes List</button>
      </Link>
      <div>Count: {count}</div>
      <button onClick={increment}>Increment</button>
      <ul>
        {users?.map((user) => (
          <li key={user.id}>
            {`name: ${user.username} - age: ${user.age}`}
            <span style={{ marginLeft: "10px" }}>
              <button onClick={(e) => handleUserDelete(e, user.id)}>
                {" "}
                Delete{" "}
              </button>
            </span>
            <span style={{ marginLeft: "10px" }}>
              <button onClick={(e) => handleUserEdit(e, user)}> Edit </button>
            </span>
          </li>
        ))}
      </ul>
      <AddBigManForm editBigMan={editBigMan} setEditBigMan={setEditBigMan} />
    </div>
  );
};

export default BigManList;
