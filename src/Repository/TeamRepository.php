<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @property EntityManagerInterface manager
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Team::class);
        $this->manager = $manager;
    }

    public function saveTeam($name)
    {
        $newTeam = new Team();

        $newTeam
            ->setName($name);

        $this->manager->persist($newTeam);
        $this->manager->flush();
        $this->manager->close();
    }

    public function updateTeam(Team $team)
    {
        $this->manager->persist($team);
        $this->manager->flush();
        $this->manager->close();
    }

    public function removeTeam(Team $team)
    {
        $this->manager->remove($team);
        $this->manager->flush();
        $this->manager->close();
    }
}
