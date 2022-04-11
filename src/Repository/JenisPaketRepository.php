<?php

namespace App\Repository;

use App\Entity\JenisPaket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JenisPaket|null find($id, $lockMode = null, $lockVersion = null)
 * @method JenisPaket|null findOneBy(array $criteria, array $orderBy = null)
 * @method JenisPaket[]    findAll()
 * @method JenisPaket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JenisPaketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JenisPaket::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(JenisPaket $entity, bool $flush = true): void
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
    public function remove(JenisPaket $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return JenisPaket[] Returns an array of JenisPaket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JenisPaket
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
