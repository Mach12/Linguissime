<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciceDone
 *
 * @ORM\Table(name="exercice_done")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciceDoneRepository")
 */
class ExerciceDone
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */

    private $points;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="exercicedone", cascade={"persist"})
     */
    private $user;

    function __construct()
    {
        $this->date = new \Datetime();
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
     * @return ExerciceDone
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
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set points
     *
     * @param string $points
     *
     * @return ExerciceDone
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return string
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ExerciceDone
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return ExerciceDone
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
