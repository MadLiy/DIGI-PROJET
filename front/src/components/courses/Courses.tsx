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
      {/* Admin */}
      {user?.roles.includes("admin") && <h2>Welcome admin</h2>}
      {/* Formator */}
      {user?.roles.includes("formator") && <h2>Welcome formator</h2>}
      {/* Student */}
      {user?.roles.includes("student") && <h2>Welcome student</h2>}
    </div>
  );
};

export default Courses;
