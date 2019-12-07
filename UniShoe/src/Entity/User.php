<?php

// src/Entity/User.php
namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6, max=100)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationdate;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shoe", mappedBy="id_user")
     */
    private $shoes;

    public function __construct()
    {
        $this->shoes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRegistrationdate(): DateTimeInterface
    {
        return $this->registrationdate;
    }

    public function setRegistrationdate(DateTimeInterface $registrationdate): DateTimeInterface
    {
        return $this->registrationdate = $registrationdate;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {}

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->plainPassword,
            $this->registrationdate
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->plainPassword,
            $this->registrationdate
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function addRole($roles)
    {
        $this->roles[] = $roles;
    }

    /**
     * @return Collection|Shoe[]
     */
    public function getShoes(): Collection
    {
        return $this->shoes;
    }

    public function addShoe(Shoe $shoe): self
    {
        if (!$this->shoes->contains($shoe)) {
            $this->shoes[] = $shoe;
            $shoe->setIdUser($this);
        }

        return $this;
    }

    public function removeShoe(Shoe $shoe): self
    {
        if ($this->shoes->contains($shoe)) {
            $this->shoes->removeElement($shoe);
            // set the owning side to null (unless already changed)
            if ($shoe->getIdUser() === $this) {
                $shoe->setIdUser(null);
            }
        }

        return $this;
    }
}
