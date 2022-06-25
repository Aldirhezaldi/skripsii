<?php

namespace App\Controller\Backend;

use App\Repository\DataTrainingRepository;
use App\Entity\DataTraining;
use App\Form\DataTestingType;
use App\Repository\PokjaRepository;
use Kematjaya\BaseControllerBundle\Controller\BaseController;
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
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @Route("/backend/perhitungan", name="app_backend_perhitungan_")
 */

class PerhitunganController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, BreacrumbBuilder $builder, DataTrainingRepository $dataTrainingRepository, PokjaRepository $pokjaRepository): Response
    {
        $dataTesting =  new DataTraining();
        $builder->add('Perhitungan Klasifikasi');
        $sumClass = $dataTrainingRepository->getProbClass();
        $getClassPokja = $pokjaRepository->getAllPokja();
        $kelas=[212,214,215,216];
        $num=[1,2,3,4];
        foreach ($num as $value) {
            $dataClass[$value]= $dataTrainingRepository->probClass($value);
        }
        // dump($getClassPokja);exit;

        $form = $this->createForm(DataTestingType::class, $dataTesting);
            $result = parent::processForm($request, $form);
            if ($result['process']) {
                return $this->json($result);
            }

        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_testing' => $dataTesting,
            'form' => $form->createView(),
            'dataClass' => $dataClass,
            'kelas' => $kelas,
            'sumClass' => $sumClass,
            'getClassPokja' => $getClassPokja,
            // 'data' => $qb
        ]);
    }
    

    public function getProboClass(DataTrainingRepository $dataTrainingRepository)
    {
        $num=[1,2,3,4];    
        $sumClass = $dataTrainingRepository->sumByClass();
        $getClass = $dataTrainingRepository->countById();
        foreach ($num as $values) {
            $jumlahProbClass[$values] = $sumClass[$values]['jumlah'] / $getClass[0]['total'];
        }
    }
}
