<?php

namespace App\Repository;

use App\Entity\HourlyRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HourlyRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method HourlyRate findOneBy(array $criteria, array $orderBy = null)
 * @method HourlyRate[]    findAll()
 * @method HourlyRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HourlyRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HourlyRate::class);
    }
}
