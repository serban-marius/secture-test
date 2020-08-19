<?php

namespace App\Repository;

use App\Entity\Players;
use App\Entity\Position;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Players|null find($id, $lockMode = null, $lockVersion = null)
 * @method Players|null findOneBy(array $criteria, array $orderBy = null)
 * @method Players[]    findAll()
 * @method Players[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @property EntityManagerInterface manager
 */
class PlayersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Players::class);
        $this->manager = $manager;
    }

    public function savePlayer($name, $team, $position, $price)
    {
        $newPlayer = new Players();

        $newPlayer
            ->setName($name)
            ->setTeam($team)
            ->setPosition($position)
            ->setPrice($price);

        $this->manager->persist($newPlayer);
        $this->manager->flush();
        $this->manager->close();
    }

    public function updatePlayer(Players $player)
    {
        $this->manager->persist($player);
        $this->manager->flush();
        $this->manager->close();
    }

    public function removePlayer(Players $player)
    {
        $this->manager->remove($player);
        $this->manager->flush();
        $this->manager->close();
    }
}
