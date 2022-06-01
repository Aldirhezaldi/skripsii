<?php

namespace App\Controller\Backend;

use App\Repository\PokjaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Phpml\Classification\NaiveBayes;
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
    public function index(BreacrumbBuilder $builder, PokjaRepository $pokjaRepository): Response
    {
        $builder->add('Perhitungan Klasifikasi');

        // $dataset = Labeled::fromIterator(new CSV('dataset/40 data.csv', true))
        //     ->apply(new NumericStringConverter());
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
        count(case when sumber_dana_id = 1 then 1 end) as "umum" ,
        count(case when sumber_dana_id = 2 then 1 end) as "dikecualikan" 
        -- another colors here
        from data_training
        group by id');
        $query->execute();
        $samples = $query->fetchAll(PDO::FETCH_NUM);
        $dataset = new Unlabeled($samples);
        dump($dataset);exit();
        // $pokja = $pokjaRepository->getAllPokja();
        // dump($pokja);exit();


        // if (isset($_POST['proses'])){

        //     $dataset = new CsvDataset('./dataset/NON ENCODE.csv',true);

        //     $samples = $dataset->getSamples();
        //     $labels = $dataset->getTargets();

        //     $dtesting[] = $_POST['jenis pengadaan'];
        //     $dtesting[] = $_POST['SUMBER DANA'];
        //     $dtesting[] = $_POST['JENIS PAKET'];

        //     $class_hasil = "";

        //     $classifier = new NaiveBayes();

        //     $classifier->train($samples, $labels);
        //     $class_hasil = $classifier->predict($dtesting);

        //     return $this->json($class_hasil);
        // }
        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            // 'pokja' => $pokja
            // 'class_hasil' => $class_hasil,
            

        ]);
    }
}
