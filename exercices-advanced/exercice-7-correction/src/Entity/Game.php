<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
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
    private $equipe1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $equipe2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $score1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotNull
     */
    private $score2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $nombre_pronostic;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pronostic", mappedBy="id_game")
     */
    private $pronostics;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateDernierPronostic;

    public function __construct()
    {
        $this->pronostics = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEquipe1(): ?string
    {
        return $this->equipe1;
    }

    public function setEquipe1(string $equipe1): self
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getEquipe2(): ?string
    {
        return $this->equipe2;
    }

    public function setEquipe2(string $equipe2): self
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    public function getScore1(): ?string
    {
        return $this->score1;
    }

    public function setScore1(string $score1): self
    {
        $this->score1 = $score1;

        return $this;
    }

    public function getScore2(): ?string
    {
        return $this->score2;
    }

    public function setScore2(string $score2): self
    {
        $this->score2 = $score2;

        return $this;
    }

    public function setDateDernierPronostic($DateDernierPronostic): self
    {
        $this->dateDernierPronostic = $DateDernierPronostic;

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
            $pronostic->addIdGame($this);
        }

        return $this;
    }

    public function removePronostic(Pronostic $pronostic): self
    {
        if ($this->pronostics->contains($pronostic)) {
            $this->pronostics->removeElement($pronostic);
            $pronostic->removeIdGame($this);
        }
        return $this;
    }

    public function __toString(){
      return $this->equipe1 . $this->equipe2;
    }
}
