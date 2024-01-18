import React, { FormEvent, useState } from "react";
import "./createCourse.css"
import CourseInterface from "../../interfaces/Course";

// Creation de cours de soutien entre eleve
const CreateCourse = () => {
    const getRandom = () => {
        return Math.trunc(Math.random() * 10000);
    };
    const [newCourse, setNewCourse] = useState<CourseInterface>({
        id: getRandom(),
        name: "",
        duree: getRandom(),
    });
    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setNewCourse((prevCourse) => ({ ...prevCourse, [name]: value }));
    };
    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        console.log(newCourse);
        // verification du form
        // appeler method de création course
    };
    return (
        <section className="course">
            <h2>CRÉER MON COURS</h2>
            <form className="create-course-form">
                <div className="course-element name">
                    <label htmlFor="name">Intitulé</label>
                    <input type="text" id="name" onChange={handleChange} name="name" required />
                </div>
                <div className="course-element duration">
                    <label htmlFor="duration">Durée</label>
                    <input type="text" id="duration" onChange={handleChange} name="duration" required />
                </div>
                <button type="submit" className="button-create" onClick={handleSubmit}>Créer mon cours</button>
            </form>
        </section>
    );
}

export default CreateCourse;