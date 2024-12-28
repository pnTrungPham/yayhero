import { Layout, Tabs } from 'antd';
import React, { useState } from 'react';
import './index.scss';
import SettingsTab from './settings';
import UserRoleRestrictionsTab from './user-role-restrictions';

const AppManagerLayout: React.FC = () => {
  const [items, setItems] = useState([
    {
      key: 'settings',
      label: 'Settings',
      children: <SettingsTab />,
    },
    {
      key: 'users-role-restrictions',
      label: 'Users Role Restrictions',
      children: <UserRoleRestrictionsTab />,
    },
  ]);

  const onChange = (key: string) => {
    console.log(key);
  };

  return (
    <Layout className='fw-rounded-lg fw-bg-[#ffffff]'>
      <Tabs onChange={onChange} items={items} className='fw-tab-container fw-px-2.5' />
    </Layout>
  );
};

export default AppManagerLayout;
