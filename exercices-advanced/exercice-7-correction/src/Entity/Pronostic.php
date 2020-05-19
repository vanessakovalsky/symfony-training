<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Game;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PronosticRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Pronostic
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
    private $score1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $score2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="pronostics")
     */
    private $id_user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", inversedBy="pronostics")
     */
    private $id_game;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    public function __construct()
    {
        $this->id_game = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function removeIdMatch(Match $idMatch): self
    {
        if ($this->id_match->contains($idMatch)) {
            $this->id_match->removeElement($idMatch);
        }

        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->id_user;
    }

    public function setIdUser(?Utilisateur $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getIdGame(): Collection
    {
        return $this->id_game;
    }

    public function addIdGame(Game $idGame): self
    {
        if (!$this->id_game->contains($idGame)) {
            $this->id_game[] = $idGame;
        }

        return $this;
    }

    public function removeIdGame(Game $idGame): self
    {
        if ($this->id_game->contains($idGame)) {
            $this->id_game->removeElement($idGame);
        }

        return $this;
    }

    public function __toString(){
      return $this->score1;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }


    /**
     * @ORM\PrePersist
    */
    public function riseUpCountPronoOnMatch(){
      $id_match = $this->id_game;
      foreach($id_match as $key => $match){
        $current_nb = $match->nombre_pronostic ;
        $match->nombre_pronostic = $current_nb +1;
        $this->id_game[$key] = $match;
      }

    }
}
