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
        $param = $dataTrainingRepository->getParameterData('nama_jenis_pengadaan', 'jenis_pengadaan');
        $classParam = $dataTrainingRepository->getClassParam();
        $pokja = $dataTrainingRepository;
        $class = $dataTrainingRepository->getNameClass('range_pagu','pagu');
        $kelas=[212,214,215,216];
        $num=[1,2,3,4];
        foreach ($num as $value) {
            $dataClass[$value]= $dataTrainingRepository->probClass($value);
        }
        // dump($pokja);exit;

        $form = $this->createForm(DataTestingType::class, $dataTesting);
            $result = parent::processForm($request, $form);
            if ($result['process']) {
                return $this->json($result);
            }

        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_testing' => $dataTesting,
            'pokja' => $pokja,
            'param' => $param,
            'classParam' => $classParam,
            'class' => $class,
            'form' => $form->createView(),
            'dataClass' => $dataClass,
            'kelas' => $kelas,
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
