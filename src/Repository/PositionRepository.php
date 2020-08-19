<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @property EntityManagerInterface manager
 */
class PositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Position::class);
        $this->manager = $manager;
    }

    public function savePosition($name)
    {
        $newPosition = new Position();

        $newPosition
            ->setName($name);

        $this->manager->persist($newPosition);
        $this->manager->flush();
        $this->manager->close();
    }

    public function updatePosition(Position $position)
    {
        $this->manager->persist($position);
        $this->manager->flush();
        $this->manager->close();
    }

    public function removePosition(Position $position)
    {
        $this->manager->remove($position);
        $this->manager->flush();
        $this->manager->close();
    }
}
