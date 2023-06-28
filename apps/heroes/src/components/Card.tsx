import React from 'react'
import userStore from '../zustand/userStore'

const Card = ({ user }) => {
    
    return (
      <div className='yayhero-card'>
        <h2>{user?.firstName}</h2>
        <img src={user?.image} alt="avatar" />
        <div className='yayhero-card-btn_nav'>
          <button className='yayhero-card-btn_edit'
          >Edit</button>
  
          <button className='yayhero-card-btn_delete'
            >Delete</button>
        </div>
      </div>
    )
  }
  
  export default Card