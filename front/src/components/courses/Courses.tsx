import UserInterface from "../../interfaces/UserInterface";
import "./courses.css";

interface UserProps {
  user: UserInterface | undefined;
}
const Courses: React.FC<UserProps> = ({ user }) => {
  console.log(user);
  return (
    <div className="courses">
      {/* Visiteur */}
      {!user && <h2>Welcome visitor</h2>}
      {/* Formateur */}
      {user?.role.includes("formateur") && <h2>Welcome formateur</h2>}
      {/* Student */}
      {user?.role.includes("student") && <h2>Welcome student</h2>}
    </div>
  );
};

export default Courses;
