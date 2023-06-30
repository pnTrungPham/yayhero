import axios from "axios";
import { useQuery } from 'react-query';

type User = {
  id: number;
  username: string;
};

const yayHeroData = window.yayHeroData

const fetchUsers = async (): Promise<User[]> => {
  const res = await axios({
    method: 'get',
    url: `${yayHeroData.restUrl}yayhero/v1/heroes`,
    headers: {
        'X-WP-Nonce': yayHeroData.restNonce,
    },
  })
  return res.data.data;
};

const BigManList = () => {
  const { data: users, isLoading, isError, error } = useQuery<User[]>('users', fetchUsers, {staleTime: 30 * 1000});

  if (isLoading) {
    return <div>Loading users...</div>;
  }

  if (isError) {
    return <div>Error: {error?.message}</div>;
  }

  return (
    <ul>
      {users?.map((user) => (
        <li key={user.id}>{`name: ${user.username}`}</li>
      ))}
    </ul>
  );
};

export default BigManList;
