import React, { useState, useEffect } from 'react'
import useStore from '../zustand/Store'
import  { User } from '../zustand/userStore'
import { Button, Form, Input } from 'antd';
import type { FormInstance } from 'antd/es/form';

interface UserInputProps {
    edit: User;
    setUserEdit: (user: User) => void;
}

const UserInput: React.FC<UserInputProps> = ({ edit, setUserEdit }) => {
    const [name, setName] = useState('')
    const [avatar, setAvatar] = useState('')
    const formRef = React.useRef<FormInstance>(null);

    const { createUsers, updateUsers } = useStore()

    const onFinish = (values: User) => {
        if (edit) {
            createUsers({edit, ...values})
        } else {
            createUsers(values)
        }
        
        setName('')
        setAvatar('')
        setUserEdit({ 
            id: null,
            firstName: '',
            image: ''
        })
        console.log('Success:', values);
    };
      
    const onFinishFailed = (errorInfo: any) => {
        console.log('Failed:', errorInfo);
    };

    useEffect(() => {
        if(edit){
          setName(edit.firstName)
          setAvatar(edit.image)

          formRef.current?.setFieldsValue({ firstName: edit.firstName});
          formRef.current?.setFieldsValue({ image: edit.image});
        }
      }, [edit])

    return (
        <Form
        name="basic"
        labelCol={{ span: 8 }}
        wrapperCol={{ span: 16 }}
        style={{ maxWidth: 600 }}
        initialValues={{ remember: true }}
        onFinish={onFinish}
        onFinishFailed={onFinishFailed}
        autoComplete="off"
        ref={formRef}
        >
            <Form.Item
                label="Username"
                name="firstName"
                rules={[{ required: true, message: 'Please input your username!' }]}
            >
                <Input/>
            </Form.Item>

            <Form.Item
                label="Image link"
                name="image"
                rules={[{ required: true, message: 'Please input your image!' }]}
            >
                <Input />
            </Form.Item>

            <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                <Button type="primary" htmlType="submit">
                    Submit
                </Button>
            </Form.Item>

        </Form>
    )

}

export default UserInput