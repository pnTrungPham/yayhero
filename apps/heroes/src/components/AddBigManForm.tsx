import { QueryClient } from "react-query";
import {
  useMutationBigMansAdd,
  useMutationBigMansUpdate,
} from "../hooks/useMutationBigMan";
import { BigMan } from "../types/bigMan.type";
import { useEffect, useState } from "react";

type User = {
  username: string;
  age: number;
};

interface BigManInputProps {
  editBigMan: BigMan;
  setEditBigMan: (user: BigMan) => void;
}

const queryClient = new QueryClient();

const AddBigManForm: React.FC<BigManInputProps> = ({
  editBigMan,
  setEditBigMan,
}) => {
  const [username, setUsername] = useState(editBigMan?.username || "");
  const [age, setAge] = useState(editBigMan?.age || 0);
  const addUserMutation = useMutationBigMansAdd();
  const updateUserMutation = useMutationBigMansUpdate();

  const handleSubmit = (event: React.FormEvent) => {
    event.preventDefault();
    if (editBigMan.username) {
      updateUserMutation.mutate({ id: editBigMan.id, username, age });
    } else {
      addUserMutation.mutate({ username: username, age: age });
    }
    setEditBigMan({
      id: 0,
      username: "",
      age: undefined,
    });
  };

  useEffect(() => {
    setUsername(editBigMan?.username || "");
    setAge(editBigMan?.age || 0);
  }, [editBigMan]);

  return (
    <form onSubmit={handleSubmit}>
      <label>
        Name:
        <input
          type="text"
          name="username"
          required
          value={username}
          onChange={(e) => setUsername(e.target.value)}
        />
      </label>
      <label>
        Age:
        <input
          type="number"
          name="age"
          required
          value={age}
          onChange={(e) => setAge(parseInt(e.target.value, 10))}
        />
      </label>
      <button type="submit">
        {editBigMan.username ? "Edit User" : "Add User"}
      </button>
    </form>
  );
};

export default AddBigManForm;
