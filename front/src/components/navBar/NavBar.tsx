import "./navBar.css";
import { MdAccountCircle } from "react-icons/md";

const NavBar = () => {
  const isLogged = false;

  return (
    <ul className="nav-bar">
      <li>
        <a href="/">Accueil</a>
      </li>
      <li>Cours</li>
      <li>Révisions</li>
      <li>
        <a href={isLogged ? "/profil" : "/login"}>
          <MdAccountCircle className="profil-icon" />
        </a>
      </li>
    </ul>
  );
};

export default NavBar;
