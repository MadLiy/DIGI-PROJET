import { useState } from "react";
import UserInterface from "../../interfaces/UserInterface";
import "./courses.css";
import CourseCard from "./CourseCard";
import CourseInterface from "../../interfaces/Course";

interface UserProps {
  user: UserInterface | undefined;
}
const Courses: React.FC<UserProps> = ({ user }) => {
  const [courses, setCourses] = useState([
    { id: 1, name: "Java SEE", duree: 60 },
  ]);

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
      {courses.map((course: CourseInterface) => {
        return (
          <div>
            <CourseCard course={course} key={course.id} />
          </div>
        );
      })}
    </div>
  );
};

export default Courses;
