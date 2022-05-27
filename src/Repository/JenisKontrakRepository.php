<?php

namespace App\Repository;

use App\Entity\JenisKontrak;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JenisKontrak>
 *
 * @method JenisKontrak|null find($id, $lockMode = null, $lockVersion = null)
 * @method JenisKontrak|null findOneBy(array $criteria, array $orderBy = null)
 * @method JenisKontrak[]    findAll()
 * @method JenisKontrak[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JenisKontrakRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JenisKontrak::class);
    }

    public function add(JenisKontrak $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JenisKontrak $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JenisKontrak[] Returns an array of JenisKontrak objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JenisKontrak
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
