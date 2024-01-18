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
    const requestInfo: Object = {
      method: 'POST',
      body: JSON.stringify(
        authUser
      ),
      headers: {
        'Content-type': 'application/json',
      }
    };
    fetch('https://127.0.0.1:8000/api/login_check', requestInfo)
      .then(function(res){
        if (res.ok){
          res.json()
            .then(function(json){
              const token = json.token;
              console.log(`token: `, token);
              document.cookie = "token" + token;
            })
        } else {
          if (res.status == 401){
            alert('Mauvais login ou mot de passe');
          } else {
            alert('Mauavaise réponse réseau');
          }
        }
      })
      .catch(function(error){
        alert("error : " + error);
      })
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
