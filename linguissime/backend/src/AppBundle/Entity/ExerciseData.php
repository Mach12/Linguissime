<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseData
 *
 * @ORM\Table(name="exercise_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciseDataRepository")
 */
class ExerciseData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

