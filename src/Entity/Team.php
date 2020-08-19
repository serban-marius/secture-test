<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Players::class, mappedBy="Team")
     */
    private $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

//    /**
//     * @return Collection|Players[]
//     */
//    public function getPlayers(): Collection
//    {
//        return $this->players;
//    }
//
//    public function addPlayer(Players $player): self
//    {
//        if (!$this->players->contains($player)) {
//            $this->players[] = $player;
//            $player->setTeam($this);
//        }
//
//        return $this;
//    }
//
//    public function removePlayer(Players $player): self
//    {
//        if ($this->players->contains($player)) {
//            $this->players->removeElement($player);
//            // set the owning side to null (unless already changed)
//            if ($player->getTeam() === $this) {
//                $player->setTeam(null);
//            }
//        }
//
//        return $this;
//    }

}
