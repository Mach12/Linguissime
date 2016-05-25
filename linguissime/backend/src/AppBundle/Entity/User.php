<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken", groups={"register", "change_account"})
 * @UniqueEntity(fields="username", message="Username already taken", groups={"register", "change_account"})
 */
class User implements UserInterface
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
    * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
    */
    private $image;

    /**
     * @var string
     *
     * @Assert\NotNull(groups={"change_account"})
     * @Assert\Length(min=4, max=20, groups={"change_account", "register"})
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @Assert\Length(min=4, max=20, groups={"change_account"})
     * @ORM\Column(name="sexe", type="string", length=20, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @Assert\Length(min=4, max=20, groups={"change_account"})
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Length(min=4, max=20, groups={"change_account"})
     * @ORM\Column(name="residence", type="string", length=255, nullable=true)
     */
    private $residence;

     /**
     * @var string
     *
     * @Assert\Length(min=4, max=20, groups={"change_account"})
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @Assert\NotNull(groups={"change_account"})
     * @Assert\Email(checkMX = true, groups={"change_account", "register"})
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="points", type="integer")
     */
    private $points;


    /**
    * @Assert\NotNull()
    */
    private $plainpassword;

    public function getRoles() 
    {
        return array('ROLE_USER');
    }

    public function getSalt() {}

    public function eraseCredentials() {}

    function __construct() {
        $this->points = 0;
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUserName($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get plainpassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainpassword;
    }

    /**
     * Set plainpassword
     *
     * @param string $plainpassword
     *
     * @return User
     */
    public function setPlainPassword($plainpassword)
    {
        $this->plainpassword = $plainpassword;

        return $this;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return User
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set residence
     *
     * @param string $residence
     *
     * @return User
     */
    public function setResidence($residence)
    {
        $this->residence = $residence;

        return $this;
    }

    /**
     * Get residence
     *
     * @return string
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
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
     * Set points
     *
     * @param integer $points
     *
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }
}
