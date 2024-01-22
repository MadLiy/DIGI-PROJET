<?php

namespace App\State;


use App\Dto\Cours\Write\CourseDtoWrite; 
use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;

class CoursProcessorWrite
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CourseDtoWrite $courseDto): Course
    {
        $course = new Course();
        $course->setName($courseDto->getName());
        $course->setDuree($courseDto->getDuree());
        dd($course);

       
        $this->entityManager->persist($course);
        $this->entityManager->flush();

        return $course;
    }
}
