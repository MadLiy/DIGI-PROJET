import CourseInterface from "../../../interfaces/Course";
import "./courseCard.css";

interface CourseProps {
  course: CourseInterface | undefined;
}
const CourseCard: React.FC<CourseProps> = ({ course }) => {
  const convertTime = (time: number | undefined) => {
    if (time) {
      let hours = Math.floor(time / 60);
      let min = time % 60;
      if (hours > 0) {
        return hours + "h" + (min > 0 ? min + "min" : "");
      }
      return min + "min";
    }
  };

  return (
    <div className="course-card">
      <p className="course-element">Nom: {course?.name}</p>
      <p className="course-element">Durée: {convertTime(course?.duree)}</p>
    </div>
  );
};

export default CourseCard;
