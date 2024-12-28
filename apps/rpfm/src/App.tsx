import { ConfigProvider } from 'antd';
import { QueryClient, QueryClientProvider } from 'react-query';
import { ReactQueryDevtools } from 'react-query/devtools';
import { RouterProvider } from 'react-router-dom';
import router from './router';

function App() {
  const queryClient = new QueryClient();
  return (
    <ConfigProvider
      theme={{
        token: {
          colorBorder: '#c0c0c1', // Border color for all inputs
          colorPrimary: '#3760f7', // Primary color
          colorPrimaryActive: '#4e5562', // Active state
        },
      }}
    >
      <div className='wp-source-container'>
        <QueryClientProvider client={queryClient}>
          <RouterProvider router={router} />
          <ReactQueryDevtools initialIsOpen={false} position='bottom-right' />
        </QueryClientProvider>
      </div>
    </ConfigProvider>
  );
}

export default App;
