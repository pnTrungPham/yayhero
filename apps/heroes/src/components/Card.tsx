import React from 'react';
import useStore from '../zustand/Store';
import  { User } from '../zustand/userStore'
interface CardProps {
  user: User;
  setUserEdit: (user: User) => void;
}

const Card: React.FC<CardProps> = ({ user, setUserEdit }) => {
  const { deleteUsers } = useStore();
  const handleDelete = (userId: number) => {
    deleteUsers(userId);
  };

  return (
    <div className="yayhero-card">
      <h1>{user?.firstName}</h1>
      <img src={user?.image} alt="avatar" />
      <div className="yayhero-card-btn_nav">
        <button className="yayhero-card-btn_edit" onClick={() => setUserEdit(user)}>
          Edit
        </button>

        <button className="yayhero-card-btn_delete" onClick={() => handleDelete(user.id)}>
          Delete
        </button>
      </div>
    </div>
  );
};

export default Card;
