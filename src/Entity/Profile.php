<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @UniqueEntity(fields="email", message="Diese E-mail wird schon benutzt. Benutze das Formular ganz unten.")
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $loginKey;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $confirmed;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", unique=true, length=100)
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * create admin key 
     *
     * @return Profile
     */
    public function createKey()
    {
        $this->loginKey = strtr( base64_encode( random_bytes(36*6/8) ), '+/=', '._-' );

        return $this;
    }
    
    /**
     * Get key
     *
     * @return string
     */
    public function getLoginKey()
    {
        return $this->loginKey;
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
     * confirm
     *
     * @param string $name
     *
     * @return Profile
     */
    public function confirm()
    {
        $this->confirmed = true;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return bool
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }
    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Profile
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
     * Set email
     *
     * @param string $email
     *
     * @return Profile
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
     * Set description
     *
     * @param string $description
     *
     * @return Profile
     */
    public function setDescription($description)
    {
        // remove additional newlines
        $this->description = preg_replace('/[\r\n]{3,}/', "\n\n", $description);

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
     * Is Admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->id == $_SERVER['ADMIN_ID'];
    }
}
