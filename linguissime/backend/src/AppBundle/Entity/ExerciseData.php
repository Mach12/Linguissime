<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;

/**
 * ExerciseData
 *
 * @ORM\Table(name="exercise_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciseDataRepository")
 * @Algolia\Index(perEnvironment=false)
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
