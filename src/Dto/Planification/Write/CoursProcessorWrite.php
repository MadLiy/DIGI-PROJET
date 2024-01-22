<?php

namespace App\Dto\Planification\Write;


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
        // Créez une nouvelle instance de l'entité Course et attribuez-lui les valeurs du DTO
        $course = new Course();
        $course->setName($courseDto->getName());
        $course->setDuree($courseDto->getDuree());

       
        $this->entityManager->persist($course);
        $this->entityManager->flush();

        return $course;
    }
}
