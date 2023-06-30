/* Use Zustand
import { RouterProvider } from "react-router-dom";
import router from "./router";
function App() {
  return (
    <div className="yayhero-container">
        <RouterProvider router={router} />
    </div>
  );
}

export default App;
*/

/* Use Zustand and react query */

import { QueryClient, QueryClientProvider } from 'react-query';
import { useCounterStore } from './zustand/counterStore';
import BigManList from './pages/BigManList';
import AddBigManForm from './components/AddBigManForm';
import { ReactQueryDevtools } from "react-query/devtools";

const queryClient = new QueryClient();

const App = () => {
  const { count, increment } = useCounterStore();

  return (
    <QueryClientProvider client={queryClient}>
      <div>
        <div>Count: {count}</div>
        <button onClick={increment}>Increment</button>

        <BigManList />
        <AddBigManForm />
      </div>
      <ReactQueryDevtools initialIsOpen={false} position="bottom-right" />
    </QueryClientProvider>
  );
};

export default App;

