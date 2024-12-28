import { Form, Input } from 'antd';
import { useWPSourceStore } from '../../../store/wpSourceStore';

const ExtraText = () => {
  return (
    <div className='fw-mt-2 fw-font-normal fw-lowercase'>
      <p>
        Default path is: <code>/var/www/alan_ninjate_usr/data/www/alan.ninjateam.org/</code>
      </p>
      <p>
        Eg: If you want to set root path access is <strong>wp-content</strong>
        folder. Just enter /var/www/alan_ninjate_usr/data/www/alan.ninjateam.org/wp-content
      </p>
    </div>
  );
};

function RootPath() {
  const setSettingsRootPath = useWPSourceStore((state) => state.setSettingsRootPath);

  const settingsRootPath = useWPSourceStore((state) => state.settings.root_path);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSettingsRootPath(e.target.value);
  };

  return (
    <Form.Item
      label='Root Path'
      name='root_path'
      extra={<ExtraText />}
      className='fw-font-medium fw-uppercase'
    >
      <Input placeholder='ex:...' onChange={handleChange} />
    </Form.Item>
  );
}

export default RootPath;
