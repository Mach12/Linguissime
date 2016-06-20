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


    public function setExercise(\AppBundle\Entity\Exercise $exercise = null)
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
     * Set text
     *
     * @param string $text
     *
     * @return ExerciseType
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set translation
     *
     * @param string $translation
     *
     * @return ExerciseType
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Set badTranslation
     *
     * @param string $badTranslation
     *
     * @return ExerciseType
     */
    public function setBadTranslation($badTranslation)
    {
        $this->badTranslation = $badTranslation;

        return $this;
    }

    /**
     * Get badTranslation
     *
     * @return string
     */
    public function getBadTranslation()
    {
        return $this->badTranslation;
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
