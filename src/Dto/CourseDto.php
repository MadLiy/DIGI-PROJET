<?php

namespace App\Dto;


 class CourseDto {

    function __construct($name, $dateCourse, $hourCourse, $instructorName)
    {
        $this->name = $name;
        $this->dateCourse = $dateCourse;
        $this->hourCourse = $hourCourse;
        $this->instructorName = $instructorName;
    }

    public ?string $name;
    public  $dateCourse = null;

    public $hourCourse = null;

    public ?string $instructorName = null ;


 }