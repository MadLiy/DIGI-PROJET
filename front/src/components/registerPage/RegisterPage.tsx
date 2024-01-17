import React, { FormEvent, useState } from "react";
import './registerPage.css'

const RegisterPage = () => {
    const [newUser, setNewUser] = useState({})

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setNewUser(prevUser => ({ ...prevUser, [name]: value }));
    }

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault()
        console.log(newUser);
        // appeler method de création user 
    }
    return (
        <section className="register">
        <h2>Inscription</h2>
        <form className="register-form">
            <div className="element name">
                <label htmlFor="name">Prénom</label>
                <input type="text" id="name" onChange={handleChange} name="name" />  
            </div>
            <div className="element lastname">
                <label htmlFor="lastname">Nom</label>
                <input type="text" id="lastname" onChange={handleChange} name="lastname" />  
            </div>
            <div className="element email">
                <label htmlFor="email">Email</label>
                <input type="email" id="email" onChange={handleChange} name="email" />  
            </div>
            <div className="element password">
                <label htmlFor="password">Mot de passe</label>
                <input type="password" id="password" onChange={handleChange} name="password" />  
            </div>
            <div className="element confirm-password">
                <label htmlFor="confirm-password">Confirmer le mot de passe</label>
                <input type="password" id="confirm-password" onChange={handleChange} name="confirm-password" />  
            </div>
            <button type="button" className="submit-button" onClick={handleSubmit}>S'inscrire</button>
        </form>
        </section>
    );
}

export default RegisterPage;