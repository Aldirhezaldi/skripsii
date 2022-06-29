<?php

namespace App\Controller\Backend;

use App\Repository\DataTrainingRepository;
use App\Entity\DataTraining;
use App\Form\DataTestingType;
use App\Repository\PokjaRepository;
use App\Filter\DataTrainingFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

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

        // $newData = $dataTrainingRepository->getLeftJoin();
        $pokja = $dataTrainingRepository;
        // dump($newData);exit;

        $form = $this->createForm(DataTestingType::class, $dataTesting, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_backend_perhitungan_data')]
            ]);
            $result = parent::processForm($request, $form);
            if ($result['process']) {
                return $this->json($result);
            }

        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_testing' => $dataTesting,
            'pokja' => $pokja,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/data", name="data", methods={"GET", "POST"})
     */
    public function data(Request $request, DataTrainingRepository $dataTrainingRepository, BreacrumbBuilder $builder): Response
    {
        $builder->add('Perhitungan Klasifikasi');
        $builder->add('All Data');

        $form = $this->createFormFilter(DataTrainingFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $dataTrainingRepository->createQueryBuilder('this'));
        return $this->render('backend/perhitungan/list_data.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_trainings' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $dataTesting = new DataTraining();
        
        $form = $this->createForm(DataTestingType::class, $dataTesting, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_backend_perhitungan_create')]
            ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('data_training/form.html.twig', [
            'data_testing' => $dataTesting,
            'form' => $form->createView(), 'title' => 'create'
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
