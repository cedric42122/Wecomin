<?php

namespace App\Repository;

use App\Entity\ServiceDelivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ServiceDelivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceDelivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceDelivery[]    findAll()
 * @method ServiceDelivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceDeliveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceDelivery::class);
    }

    // /**
    //  * @return ServiceDelivery[] Returns an array of ServiceDelivery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceDelivery
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
