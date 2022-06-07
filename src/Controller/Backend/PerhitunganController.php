<?php

namespace App\Controller\Backend;

use App\Repository\DataTrainingRepository;
use App\Repository\PokjaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Phpml\Classification\NaiveBayes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Phpml\Dataset\CsvDataset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\Extractors\SQLTable;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Datasets\Unlabeled;
use PDO;

/**
 * @Route("/backend/perhitungan", name="app_backend_perhitungan_")
 */

class PerhitunganController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, BreacrumbBuilder $builder, DataTrainingRepository $dataTrainingRepository): Response
    {
        $builder->add('Perhitungan Klasifikasi');
        $pdo = new PDO('pgsql:user=postgres;dbname=backup', 'postgres', 'buildstrike');

        $query = $pdo->prepare('select pokja_id,
        count(case when jenis_pengadaan_id = 1 then 1 end) as "BARANG" ,
        count(case when jenis_pengadaan_id = 2 then 1 end) as "KONSTRUKSI" ,
        count(case when jenis_pengadaan_id = 3 then 1 end) as "KONSULTASI" ,
        count(case when jenis_pengadaan_id = 4 then 1 end) as "JASA_LAINNYA",
        count(case when sumber_dana_id = 1 then 1 end) as "APBD" ,
        count(case when sumber_dana_id = 2 then 1 end) as "APBN" ,
        count(case when sumber_dana_id = 3 then 1 end) as "BLUD" ,
        count(case when sumber_dana_id = 4 then 1 end) as "LAINNYA",
        count(case when jenis_kontrak_id = 1 then 1 end) as "LUMSUM",
        count(case when jenis_kontrak_id = 2 then 1 end) as "HARGA SATUAN",
	    count(case when jenis_kontrak_id = 3 then 1 end) as "GABUNGAN LUMSUM DAN HARGA SATUAN",
	    count(case when jenis_kontrak_id = 4 then 1 end) as "WAKTU PENUGASAN"
        from data_training
        group by id');
        $query->execute();
        $samples = $query->fetchAll(PDO::FETCH_NUM);
        $dataset = new Unlabeled($samples);
        // dump($dataset);exit();
        
        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'queryResult' => $dataset,
            

        ]);
    }
}
