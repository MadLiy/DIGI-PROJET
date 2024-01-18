import CourseInterface from "../../interfaces/Course";

interface CourseProps {
  course: CourseInterface | undefined;
}
const CourseCard: React.FC<CourseProps> = ({ course }) => {
  const convertTime = (time) => {
    let hours = Math.floor(time / 60);
    let min = time % 60;
    if (hours > 0) {
      return hours + "h" + (min > 0 ? min + "min" : "");
    }
    return min + "min";
  };

  return (
    <div>
      <p>Nom: {course?.name}</p>
      <p>Durée {convertTime(course?.duree)}</p>
    </div>
  );
};

export default CourseCard;
