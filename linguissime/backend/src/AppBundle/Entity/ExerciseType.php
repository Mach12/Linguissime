<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;

/**
 * ExerciseType
 *
 * @ORM\Table(name="exercise_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciseTypeRepository")
 * @Algolia\Index(perEnvironment=false)
 */
class ExerciseType
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     * @Algolia\Attribute
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="exercisetype")
     */
    private $exercise;


    public function setExercise(Exercise $exercise = null)
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return ExerciseType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}
