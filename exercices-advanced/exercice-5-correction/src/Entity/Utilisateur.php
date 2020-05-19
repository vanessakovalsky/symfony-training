<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pronostic", mappedBy="id_user")
     */
    private $pronostics;

    public function __construct()
    {
        $this->pronostics = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Pronostic[]
     */
    public function getPronostics(): Collection
    {
        return $this->pronostics;
    }

    public function addPronostic(Pronostic $pronostic): self
    {
        if (!$this->pronostics->contains($pronostic)) {
            $this->pronostics[] = $pronostic;
            $pronostic->setIdUser($this);
        }

        return $this;
    }

    public function removePronostic(Pronostic $pronostic): self
    {
        if ($this->pronostics->contains($pronostic)) {
            $this->pronostics->removeElement($pronostic);
            // set the owning side to null (unless already changed)
            if ($pronostic->getIdUser() === $this) {
                $pronostic->setIdUser(null);
            }
        }

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }


      /** @see \Serializable::serialize() */
     public function serialize()
     {
         return serialize(array(
             $this->id,
             $this->username,
             $this->password,
             // see section on salt below
             // $this->salt,
         ));
     }

     /** @see \Serializable::unserialize() */
     public function unserialize($serialized)
     {
         list (
             $this->id,
             $this->username,
             $this->password,
             // see section on salt below
             // $this->salt
         ) = unserialize($serialized, array('allowed_classes' => false));
     }

    public function __toString(){
      return $this->username;
    }
}
