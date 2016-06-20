<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseType
 *
 * @ORM\Table(name="exercise_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciseTypeRepository")
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
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string", length=255)
     */
    private $translation;

    /**
     * @var string
     *
     * @ORM\Column(name="bad_translation", type="string", length=255)
     */
    private $badTranslation;


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
}

