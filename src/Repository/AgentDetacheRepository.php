<?php

namespace App\Repository;

use App\Entity\AgentDetache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgentDetache>
 *
 * @method AgentDetache|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentDetache|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentDetache[]    findAll()
 * @method AgentDetache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentDetacheRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, AgentDetache::class);
        $this->manager = $manager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AgentDetache $entity, bool $flush = true): void
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
    public function remove(AgentDetache $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Retourne la liste des agents pour lesquels on a pas encore cotisé
     */
    public function findListeACotiser($reversement)
    {
        return $this->manager->createQuery(
            "SELECT a.id, CONCAT(a.noms,' - (', a.matricule,')') as nom
                FROM App\Entity\AgentDetache a
                WHERE a.id NOT IN ( SELECT ad.id
                                FROM App\Entity\Cotisation c
                                JOIN c.agent ad
                                JOIN c.reversement r
                                WHERE r = :reversement )
                ORDER BY nom"
        )
            ->setParameter('reversement', $reversement)
            ->getResult();
    }

    // /**
    //  * @return AgentDetache[] Returns an array of AgentDetache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgentDetache
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
