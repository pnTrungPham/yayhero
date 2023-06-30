import axios from "axios";
import { useQuery } from "react-query";
import AddBigManForm from "../components/AddBigManForm";
import useStore from "../zustand/Store";
import { Link } from "react-router-dom";
import { yayHeroData } from "../localize";

type User = {
  id: number;
  username: string;
};

const fetchUsers = async (): Promise<User[]> => {
  const res = await axios({
    method: "get",
    url: `${yayHeroData.restUrl}yayhero/v1/heroes`,
    headers: {
      "X-WP-Nonce": yayHeroData.restNonce,
    },
  });
  return res.data.data;
};

const BigManList = () => {
  const {
    data: users,
    isLoading,
    isError,
    error,
  } = useQuery<User[]>("users", fetchUsers, { staleTime: 30 * 1000 });
  const { count, increment } = useStore();

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
          <li key={user.id}>{`name: ${user.username}`}</li>
        ))}
      </ul>
      <AddBigManForm />
    </div>
  );
};

export default BigManList;
