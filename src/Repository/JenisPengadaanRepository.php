<?php

namespace App\Repository;

use App\Entity\JenisPengadaan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JenisPengadaan|null find($id, $lockMode = null, $lockVersion = null)
 * @method JenisPengadaan|null findOneBy(array $criteria, array $orderBy = null)
 * @method JenisPengadaan[]    findAll()
 * @method JenisPengadaan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JenisPengadaanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JenisPengadaan::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(JenisPengadaan $entity, bool $flush = true): void
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
    public function remove(JenisPengadaan $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return JenisPengadaan[] Returns an array of JenisPengadaan objects
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
    public function findOneBySomeField($value): ?JenisPengadaan
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
