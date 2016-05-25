<?php

namespace AppBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @Assert\NotBlank()
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @Assert\NotBlank()
     */
    private $content;


    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}
