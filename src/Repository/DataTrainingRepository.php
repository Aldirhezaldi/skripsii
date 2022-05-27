<?php

namespace App\Repository;

use App\Entity\DataTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DataTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataTraining[]    findAll()
 * @method DataTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTraining::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DataTraining $entity, bool $flush = true): void
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
    public function remove(DataTraining $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function oneHotEncodeByName()
    {
        // $qb = $this->createQueryBuilder('d')
        //     ->select('d.id, count(CASE WHEN j.id = 1 THEN 1 END) as BARANG,
        //         count(CASE WHEN j.id = 2 THEN 1 END) as KONSTRUKSI,
        //         count(CASE WHEN j.id = 3 THEN 1 END) as KONSULTASI,
        //         count(CASE WHEN j.id = 1 THEN 1 END) as JASA_LAINNYA,
        //         count(CASE WHEN s.id = 1 THEN 1 END) as APBD,
        //         count(CASE WHEN s.id = 2 THEN 1 END) as APBN, 
        //         count(CASE WHEN s.id = 3 THEN 1 END) as BLUD,
        //         count(CASE WHEN s.id = 4 THEN 1 END) as LAINNYA,
        //         count(CASE WHEN P.id = 1 THEN 1 END) as umum,
        //         count(CASE WHEN p.id = 2 THEN 1 END) as dikecualikan')
        //     ->join('d.jenis_pengadaan', 'j')
        //     ->join('d.jenis_paket', 'p')
        //     ->join('d.sumber_dana', 's')
        //     ->groupBy('d.id');
        // return $qb->getQuery()->getResult();
        // return $qb->getQuery()->getResult();

    }

    // /**
    //  * @return DataTraining[] Returns an array of DataTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DataTraining
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
