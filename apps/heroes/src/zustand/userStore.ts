import axios from "axios";
import { StateCreator } from "zustand";

export interface User {
  id: number | null;
  firstName: string;
  image: string;
}

export interface UserState {
  data: User[];
  loading?: boolean;
  error?: any;
  getUsers: () => void;
  createUsers: (newUser: User) => void;
  updateUsers: (updateUser: User) => void;
  deleteUsers: (id: Number) => void;
}
const initialState = {
  data: [
    {
      id: 200,
      firstName: "Terry 1",
      image: "https://robohash.org/hicveldicta.png",
    },
  ],
  loading: false,
};

export const useUserStore: StateCreator<UserState> = (set) => {
  return {
    data: initialState.data,
    loading: initialState.loading,
    getUsers: async () => {
      try {
        const res = await axios.get(`https://dummyjson.com/users?limit=10`);
        set(
          (state) => {
            console.log(state);
            (state.data = [...res.data.users, ...state.data]),
              (state.loading = false),
              (state.error = undefined);
          },
          false,
          `users/get_success`
        );
      } catch (err) {
        set({ loading: false, error: err });
      }
    },
    createUsers: async (newUser: User) => {
      try {
        const res = await axios.post(
          `https://dummyjson.com/users/add`,
          newUser
        );
        set(
          (state) => {
            state.loading = false;
            state.data = [res.data, ...state.data];
          },
          false,
          `users/create_success`
        );
      } catch (err) {
        set(
          (state) => ({
            loading: false,
            error: err,
          }),
          false,
          "users/create_error"
        );
      }
    },
    updateUsers: async (updateUser: User) => {
      try {
        set(
          (state) => {
            state.loading = false;
            state.data = state.data?.map((item) =>
              item.id === updateUser.id ? updateUser : item
            );
          },
          false,
          "users/update_success"
        );
      } catch (err) {
        set(
          (state) => {
            state.loading = false;
            state.error = err;
          },
          false,
          "users/update_error"
        );
      }
    },
    deleteUsers: async (id: Number) => {
      try {
        set(
          (state) => {
            state.loading = false;
            state.data = state.data?.filter((item) => item.id !== id);
          },
          false,
          "users/delete_success"
        );
      } catch (err) {
        set(
          (state) => {
            state.loading = false;
            state.error = err;
          },
          false,
          "users/delete_error"
        );
      }
    },
  };
};
