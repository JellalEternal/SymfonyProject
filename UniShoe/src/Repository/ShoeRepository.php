<?php

namespace App\Repository;

use App\Entity\Shoe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Shoe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shoe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shoe[]    findAll()
 * @method Shoe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shoe::class);
    }

    public function findAllShoe(): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Shoe[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('s')
            ->setMaxResults(3)
            ->orderBy('s.created_at','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findSoldUser($userID): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.id_user = :id')
            ->setParameter('id', $userID)
            ->getQuery()
            ->getResult();
    }

    public function findPurchaseShoe($userID): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.id_user != :id')
            ->setParameter('id', $userID)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Shoe
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
