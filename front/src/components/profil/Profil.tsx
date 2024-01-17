import React, { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import UserInterface from "../../interfaces/UserInterface";

interface UserProps {
  user: UserInterface | undefined;
}
const Profil: React.FC<UserProps> = ({ user }) => {
  const navigate = useNavigate();

  useEffect(() => {
    !user && navigate("/login");
  }, [user]);

  return (
    <div>
      <h2>Profil Page</h2>
    </div>
  );
};

export default Profil;
