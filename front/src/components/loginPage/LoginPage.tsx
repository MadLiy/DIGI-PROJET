import React, { FormEvent, useState } from "react";
import "./loginPage.css";

const LoginPage = () => {
  const [user, setUser] = useState({});

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setUser((prevUser) => ({ ...prevUser, [name]: value }));
  };

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();
    console.log(user);
    // appeler method de connexion
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
