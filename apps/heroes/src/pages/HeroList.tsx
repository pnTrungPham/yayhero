import React, { useState, useEffect } from 'react'
import useStore from '../zustand/Store'
import Card from '../components/Card'
import UserInput from '../components/UserInput'


function HeroList() {
    const {
        themeState: {dark},
        toggleDarkMode,
        userState: {data: users, loading, error},
        getUsers
    } = useStore()

    useEffect(() => {
        getUsers()
    }, [getUsers])
      console.log(users);
    return (
        <div>
            <header className="yayhero-herolist-title">
                <h4>Heroes</h4>
            </header>
            <div style={{cursor: 'pointer', padding: '15px'}}>
                {
                    dark
                    ?  <img src='https://yay-wp.test/wp-content/plugins/yayhero/apps/heroes/src/images/dark.png' alt="Dark" width={50} onClick={() => toggleDarkMode(false)}/>
                    :  <img src='https://yay-wp.test/wp-content/plugins/yayhero/apps/heroes/src/images/light.png' alt="Ligth" width={50} onClick={() => toggleDarkMode(true)} />
                }
            </div>
            <div>
            <UserInput/>
            </div>
            <div className='yayhero-card-container'>
                {
                    users.map(user => (
                        <React.Fragment key={user.id}>
                            <Card user={user} />
                        </React.Fragment>
                    ))
                }
            </div>
        </div>
    );
}
export default HeroList;