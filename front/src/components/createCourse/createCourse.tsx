import React from "react";
import "./createCourse.css"

// Creation de cours de soutien entre eleve
const CreateCourse = () => {
    return (
        <section className="course">
            <h2>CRÉER MON COURS</h2>
            <form className="create-course-form">
                <div className="element name">
                    <label htmlFor="name">Intitulé</label>
                    <input type="text" id="name" name="name"/>
                </div>
                <div className="element duration">
                    <label htmlFor="duration">Durée</label>
                    <input type="text" id="duration" name="duration"/>
                </div>
                <button type="submit" className="button-create">Créer mon cours</button>
            </form>
        </section>
    );
}

export default CreateCourse;