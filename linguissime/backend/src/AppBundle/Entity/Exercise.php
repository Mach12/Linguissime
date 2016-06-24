<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Exercise
 *
 * @ORM\Table(name="exercise")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciseRepository")
 * @UniqueEntity("name")
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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Algolia\Attribute
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Algolia\Attribute
     */
    private $slug;

    /**
     *
     * @ORM\Column(name="difficulty", type="integer")
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
    * @ORM\Column(name="data", type="json_array")
    * @Algolia\Attribute
    */
    protected $data;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Algolia\Attribute
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="exercise")
     * @Algolia\Attribute
     */
    private $user;

    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }


    /**
     * Get id
     *
     * @return integer
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
     * @return integer
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

    /**
     * Set data
     *
     * @param array $data
     *
     * @return Exercise
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Exercise
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
