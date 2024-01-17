import './navBar.css'
import { MdAccountCircle } from "react-icons/md";

const NavBar = () => {
    return (
        <ul className="nav-bar">
            <li>Accueil</li>
            <li>Cours</li>
            <li>Révisions</li>
            <li><MdAccountCircle className="profil-icon"/></li>
        </ul>
    );
}

export default NavBar;