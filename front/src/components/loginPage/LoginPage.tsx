import React, { FormEvent, useState } from "react";
import "./loginPage.css";
import UserInterface from "../../interfaces/UserInterface";
// import { jwt_decode } from 'jwt-decode';

interface UserProps {
  setUser: (user: UserInterface | undefined) => void;
}

function b64DecodeUnicode(str) {
  return decodeURIComponent(atob(str).replace(/(.)/g, (m, p) => {
      let code = p.charCodeAt(0).toString(16).toUpperCase();
      if (code.length < 2) {
          code = "0" + code;
      }
      return "%" + code;
  }));
}
function base64UrlDecode(str) {
  let output = str.replace(/-/g, "+").replace(/_/g, "/");
  switch (output.length % 4) {
      case 0:
          break;
      case 2:
          output += "==";
          break;
      case 3:
          output += "=";
          break;
      default:
          throw new Error("base64 string is not of the correct length");
  }
  try {
      return b64DecodeUnicode(output);
  }
  catch (err) {
      return atob(output);
  }
}
function jwtDecode(token) {
  const part = token.split(".")[1];
  let decoded = base64UrlDecode(part);
  return JSON.parse(decoded);

}

const LoginPage: React.FC<UserProps> = ({ setUser }) => {
  const [authUser, setAuthUser] = useState({});

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setAuthUser((prevAuthUser) => ({ ...prevAuthUser, [name]: value }));
  };

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();
    let requestInfo: Object = {
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
              let token = json.token;
              let decoded = jwtDecode(token);
              // let decoded = jwt.decode(token);
              console.log(decoded);
              console.log(`token: `, token);
              document.cookie = "token" + token;
            })
        } else {
          if (res.status == 401){
            alert('Mauvais login ou mot de passe');
          } else {
            alert('Mauvaise réponse réseau');
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
