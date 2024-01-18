import React, { FormEvent, useState } from "react";
import "./loginPage.css";
import UserInterface from "../../interfaces/UserInterface";

interface UserProps {
  setUser: (user: UserInterface | undefined) => void;
}

const LoginPage: React.FC<UserProps> = ({ setUser }) => {
  const [authUser, setAuthUser] = useState({});

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setAuthUser((prevAuthUser) => ({ ...prevAuthUser, [name]: value }));
  };

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();
    console.log(authUser);
    // appeler method de connexion
    // recup retour puis setUSer()
  };
  return (
    <section className="connect">
      <h2>Connexion</h2>
      <form className="register-form">
        <div className="element email">
          <label htmlFor="email">Email</label>
          <input type="email" id="email" onChange={handleChange} name="email" />
        </div>
        <div className="element password">
          <label htmlFor="password">Mot de passe</label>
          <input
            type="password"
            id="password"
            onChange={handleChange}
            name="password"
          />
        </div>
        <a href="/register">S'enregistrer</a>
        <button type="button" className="submit-button" onClick={handleSubmit}>
          Se connecter
        </button>
      </form>
    </section>
  );
};

export default LoginPage;
