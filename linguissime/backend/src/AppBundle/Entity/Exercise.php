<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Exercise
 *
 * @ORM\Table(name="exercise")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciseRepository")
 * @Algolia\Index(perEnvironment=false)
 */
class Exercise
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Algolia\Attribute
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Algolia\Attribute
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255)
     * @Algolia\Attribute
     */
    private $difficulty;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     * @Algolia\Attribute
     */
    private $duration;

    /**
    * @ORM\OneToMany(targetEntity="ExerciseType", mappedBy="exercise", cascade={"persist"})
    * @Algolia\Attribute
    */
    protected $exercisetype;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Algolia\Attribute
     */
    private $description;


    public function __construct()
    {
        $this->exercisetype = new ArrayCollection();
    }

    public function addExerciseType(ExerciseType $exercisetype)
    {   
        $exercisetype->setExercise($this);
        $this->exercisetype->add($exercisetype);
    }

    public function removeExerciseType(ExerciseType $exercisetype)
    {
        $this->exercisetype->removeElement($exercisetype);
    }

    public function getExerciseType()
    {
        return $this->exercisetype;
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
     * Set name
     *
     * @param string $name
     *
     * @return Exercise
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set difficulty
     *
     * @param string $difficulty
     *
     * @return Exercise
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Exercise
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Exercise
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
