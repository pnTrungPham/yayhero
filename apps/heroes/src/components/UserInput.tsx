import React, { useState, useEffect } from 'react'
import useStore from '../zustand/Store'
import { Button, Upload, Form, Input } from 'antd';



const UserInput = () => {
    const [name, setName] = useState('')
    const [avatar, setAvatar] = useState('')

    const { createUsers } = useStore()

    const onFinish = (values: any) => {
        console.log(values);
        //values.preventDefault()
        createUsers(values)
        setName('')
        setAvatar('')
        console.log('Success:', values);
    };
      
    const onFinishFailed = (errorInfo: any) => {
        console.log('Failed:', errorInfo);
    };

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
        >
            <Form.Item
                label="Username"
                name="firstName"
                initialValue=""
                rules={[{ required: true, message: 'Please input your username!' }]}
            >
                <Input />
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