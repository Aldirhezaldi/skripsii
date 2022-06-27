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
    
    public function probClass($class)
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('count(d.pokja) as kelas')
                    ->where('d.pokja = '.$class);
        return $qb->getQuery()->getResult()[0];
    }

    public function countById()
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('count(d) as total');
        return $qb->getQuery()->getResult()[0];
    }

    public function sumByClass()
    {
        $num=[1,2,3,4];
        foreach ($num as $value) {
            $qb = $this->createQueryBuilder('d')
                   ->select('count(d.pokja) as jumlah')
                   ->where('d.pokja = '.$value);
                   $jumlahKelas[$value]=$qb->getQuery()->getResult()[0];
        }
        return $jumlahKelas;
    }

    public function getProbClass()
    {
        $sumClass = $this->sumByClass();
        $countClass = $this->countById();

        $num=[1,2,3,4];
        foreach ($num as $value) {
            $jumlahProbClass[$value] = $sumClass[$value]['jumlah'] / $countClass[0]['total'];
        }
        return $jumlahProbClass;
    }

    public function getClassParam()
    {
            $qb = $this->createQueryBuilder('d')
                   ->select('distinct (p.nama_pokja) as Kelas, count(d) as Jumlah, count(d)/104.0 as Probabilitas')
                   ->leftJoin('d.pokja', 'p')
                   ->groupBy('p.nama_pokja')
                   ->orderBy('p.nama_pokja', 'ASC');
                   
            return $qb->getQuery()->getResult();
    }

    public function getParameterData($nama, $class)
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('distinct (p.'.$nama.') as parameter')
                    ->leftJoin('d.'.$class, 'p')
                    ->orderBy('p.'.$nama, 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function getPokja($kelas)
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('count(p.nama_pokja) as kelas')
                    ->leftJoin('d.pokja', 'p')
                    ->where('p.nama_pokja = :pokja')
                    ->setParameter('pokja', $kelas);
                    return $qb->getQuery()->getResult()[0]; 
    }

    public function getC($select, $join)
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('distinct (p.'.$select.') as parameter')
                    ->leftJoin('d.'.$join , 'p')
                    ->orderBy('p.'.$select, 'ASC');
        return $qb->getQuery()->getResult()[0];
    }

    public function getLeftJoin()
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('p.nama_pokja, j.nama_jenis_pengadaan, s.nama_sumber_dana, k.nama_jenis_kontrak, pg.range_pagu')
                    ->leftJoin('d.pokja', 'p')
                    ->leftJoin('d.jenis_pengadaan', 'j')
                    ->leftJoin('d.sumber_dana', 's')
                    ->leftJoin('d.jenis_kontrak', 'k')
                    ->leftJoin('d.pagu', 'pg')
                    ->orderBy('p.nama_pokja', 'ASC');
                    return $qb->getQuery()->getResult();
    }

    public function getNameClass($nama, $parameter)
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('distinct p.'.$nama)
                    ->leftJoin('d.'.$parameter, 'p')
                    ->orderBy('p.'.$nama, 'ASC');
        return $qb->getQuery()->getResult();
    }
    public function getJP($c)
    {
        $qb = $this->createQueryBuilder('d')
                    ->select('distinct (d.'.$c.') as kelas');
        return $qb->getQuery()->getResult();
    }

    public function getConditionProb($parameter, $nilai)
    {
        $jumlahDataKelas = $this->sumByClass();
        $num=[1,2,3,4];
        foreach ($num as $value) {
            $qb = $this->createQueryBuilder('d')
                   ->select('count('.$parameter.')')
                   ->where($parameter = $nilai .'and d.pokja ='.$value);
                   $conditionProb[$value] =  $qb->getQuery()->getResult()[0] / $jumlahDataKelas[$value];
        }
        return $conditionProb;
    }

    public function getClassProb($data)
    {
        $num=[1,2,3,4];
        $attribut['jenis_pengadaan'] = $this->getConditionProb('jenis_pengadaan', $data['jenis_pengadaan']);
        $attribut['sumber_dana'] = $this->getConditionProb('sumber_dana', $data['sumber_dana']);
        $attribut['jenis_kontrak'] = $this->getConditionProb('jenis_kontrak', $data['jenis_kontrak']);
        $attribut['pagu'] = $this->getConditionProb('pagu', $data['pagu']);

        foreach ($num as $value) {
            $prob[$value] = $attribut['jenis_pengadaan'][$value] * $attribut['sumber_dana'][$value] *
            $attribut['jenis_kontrak'][$value] * $attribut['pagu'][$value] * $this->getProbClass()[$value];
        }
        if ($prob[1] > $prob[2]) {
            return 'Pokja pemilihan 212';
        } else if($prob[1] < $prob[2]){
            return 'Pokja Pemiligan 214';
        } 
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
