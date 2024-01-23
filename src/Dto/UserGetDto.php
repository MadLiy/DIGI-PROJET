<?php


namespace App\Dto;

use App\Entity\Session;
use Symfony\Component\Validator\Constraints as Assert;

 class UserGetDto
{
    function __construct($user)
    {
        $this -> email = $user->getEmail();
        $this -> name = $user->getName();
        $this -> lastName = $user->getLastName();

        $sessions =  clone $user->getParticipe();
         if(end($sessions)=== false){
        }
         else{
            
            foreach ($sessions as $session){
                $this->sessions[]= $session->getName();
                $planificationsSessions[]= $session->getPlanifications();
                foreach ($planificationsSessions as $planificationSession)
                { 
                    foreach ($planificationSession as $planification){
                        $this-> CourseParticipate[]= new CourseDto($planification -> getOrganise()->getName(),
                    $planification -> getDateDebut(),
                   $planification -> getHeureDebut(),
                    $planification -> getInterviens()->getName());
                    }
                    
                }
            }
           
        }
         
          $courses = clone $user->getDispense();
          foreach ($courses as $course){
                  $this-> courseGiven[]= $course->getName();
          }
    }

    public ?string $email;
    public ?string $name = null;

    public ?string $lastName = null;

    public ? array $sessions = null ;

    // public $lastSession = null ;

    public ?array $courseGiven=[];

    public ?array $CourseParticipate= [];
}