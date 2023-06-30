import axios from "axios";
import { useMutation, QueryClient } from 'react-query';
import { useCounterStore } from '../zustand/counterStore';

const yayHeroData = window.yayHeroData

type User = {
    username: string;
    age: number;
};
const queryClient = new QueryClient()

const addUser = async (user: User) => {
    const res = await axios({
        method: 'post',
        url: `${yayHeroData.restUrl}yayhero/v1/heroes`,
        data: user,
        headers: {
            'X-WP-Nonce': yayHeroData.restNonce,
        },
    })
    return res.data;
};

const AddBigManForm = () => {
  const { increment } = useCounterStore();

  const addUserMutation = useMutation(addUser, {
    onSuccess: () => {
        console.log('onSuccess');
      // Refresh the user list after successful addition
      queryClient.invalidateQueries('users');
      increment();
    },
  });

  const handleSubmit = (event: React.FormEvent) => {
    event.preventDefault();
    const form = event.target as HTMLFormElement;
    const { username, age } = form.elements as typeof form.elements & User;
    addUserMutation.mutate({ username: username.value, age: parseInt(age.value, 10) });
    form.reset();
  };

  return (
    <form onSubmit={handleSubmit}>
      <label>
        Name:
        <input type="text" name="username" required />
      </label>
      <label>
        Age:
        <input type="number" name="age" required />
      </label>
      <button type="submit">Add User</button>
    </form>
  );
};

export default AddBigManForm;
