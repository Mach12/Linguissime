<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BadgeManager
 *
 * @ORM\Table(name="badge_manager")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BadgeManagerRepository")
 */
class BadgeManager     
{   
    // BadgeAchievement  
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

       /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Badge")
   * @ORM\JoinColumn(nullable=false)
   */
  private $badge;

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   */
  private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set badge
     *
     * @param \AppBundle\Entity\Badge $badge
     *
     * @return BadgeManager
     */
    public function setBadge(\AppBundle\Entity\Badge $badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * Get badge
     *
     * @return \AppBundle\Entity\Badge
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return BadgeManager
     */
    public function setUser(\AppBundle\Entity\User $user)
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

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return BadgeManager
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
