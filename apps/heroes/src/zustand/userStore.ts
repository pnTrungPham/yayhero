import axios from "axios";

// export interface userState {
//     data: Array<any>
//     loading: boolean
//     error: any
// }

const userState = {
    data: [
        {
            id: 200, 
            firstName: 'Terry 1', 
            lastName: 'Medhurst',
            image: "https://robohash.org/hicveldicta.png"
        }
    ],
    loading: false,
    error: undefined
}

let userStore = (set:any, get:any) => {
    return {
        userState,
        getUsers: async () => {

            set(
                (state:any) => {
                    return {
                        ...state,
                        userState:{
                            ...state.userState,
                            loading: true
                        }
                    }
                },
                false,
                `users/fetch_request`
            )

            try {
                const res = await axios.get(`https://dummyjson.com/users?limit=10`)
                set(
                    (state:any) => {
                        return {
                            ...state,
                            userState:{
                                ...state.userState,
                                loading: false,
                                data: [...res.data.users, ...state.userState.data]  
                            }
                        }
                    },
                    false,
                    `users/fetch_success`
                  )
            }catch (err) {
                set(
                    (state:any) => {
                        return {
                            ...state,
                            userState:{
                                ...state.userState,
                                loading: false,
                                error: err
                            }
                        }
                    },
                    false,
                    `users/fetch_error`
                  )
            }
        },
        createUsers: async (newUser:any) => {
            set(
                (state:any) => {
                    return {
                        ...state,
                        userState:{
                            ...state.userState,
                            loading: true
                        }
                    }
                },
                false,
                `users/create_request`
            )

            try {
                const res = await axios.post(`https://dummyjson.com/users/add`, newUser);

                set(
                    (state:any) => {
                        console.log(state.userState);
                        return {
                            ...state,
                            userState:{
                                ...state.userState,
                                loading: false,
                                data: [res.data, ...state.userState.data] 
                            }
                        }
                    },
                    false,
                    `users/fetch_success`
                )
            } catch (err) {
                set(
                    (state:any) => {
                      state.userState.loading = false;
                      state.userState.error = err;
                    },
                    false,
                    "users/create_error"
                )
            }
        }
    }
}

export default userStore