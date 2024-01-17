import UserInterface from "../../interfaces/UserInterface";
import "./courses.css";

interface UserProps {
  user: UserInterface | undefined;
}
const Courses: React.FC<UserProps> = ({ user }) => {
  return (
    <div className="courses">
      {user?.role.includes("formateur") ? (
        <h2>Welcome formateur</h2>
      ) : (
        // section des formateurs
        // sections des élèves
        <h2> Welcome student</h2>
      )}
    </div>
  );
};

export default Courses;
