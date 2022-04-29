<?php

namespace App\Repository;

use App\Entity\PositionSolde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PositionSolde>
 *
 * @method PositionSolde|null find($id, $lockMode = null, $lockVersion = null)
 * @method PositionSolde|null findOneBy(array $criteria, array $orderBy = null)
 * @method PositionSolde[]    findAll()
 * @method PositionSolde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionSoldeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PositionSolde::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PositionSolde $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PositionSolde $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PositionSolde[] Returns an array of PositionSolde objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PositionSolde
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
