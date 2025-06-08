<?php

namespace App\Repository;

use App\Entity\ScanRead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScanRead>
 */
class ScanReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScanRead::class);
    }

    public function findAllByUser($user)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id_user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
