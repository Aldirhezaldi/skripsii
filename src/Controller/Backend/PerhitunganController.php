<?php

namespace App\Controller\Backend;

use App\Repository\PokjaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Phpml\Classification\NaiveBayes;
use Symfony\Component\Routing\Annotation\Route;
use Phpml\Dataset\CsvDataset;

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

        $pokja = $pokjaRepository->getAllPokja();
        dump($pokja);exit();


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
            'pokja' => $pokja
            // 'class_hasil' => $class_hasil,
            

        ]);
    }
}
