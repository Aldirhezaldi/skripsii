<?php

namespace App\Controller\Backend;

use App\Entity\DataTesting;
use App\Repository\DataTrainingRepository;
use App\Entity\DataTraining;
use App\Form\DataTestingType;
use App\Repository\PokjaRepository;
use App\Filter\DataTrainingFilterType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request, DataTestingType $dataTestingType, BreacrumbBuilder $builder, DataTrainingRepository $dataTrainingRepository, PokjaRepository $pokjaRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $dataTesting =  new DataTesting();
        $builder->add('Perhitungan Klasifikasi');

        // $newData = $dataTrainingRepository->getLeftJoin();
        $pokja = $dataTrainingRepository;
        $leftJoin = $dataTrainingRepository->getLeftJoin();
        $leftJoin2 = $dataTrainingRepository->getLeftJoin2();
        $hai = $dataTestingType;

        $form = $this->createForm(DataTestingType::class, $dataTesting, [
            'action' => $this->generateUrl('app_backend_perhitungan_post'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // var_dump($dataTesting);die;
            // $entityManagerInterface->persist($dataTesting);
            // $entityManagerInterface->flush();
            $queryBuilder = $this->buildFilter($request, $form, $dataTrainingRepository->createQueryBuilder('this'));
            return $this->redirectToRoute('app_backend_perhitungan_post',[
                'app_backend_perhitungan_post' => $form->getData(),
                'hasil' => parent::createPaginator($queryBuilder, $request),
                'form' =>$form
            ]);
        }
        
        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_testing' => $dataTesting,
            'leftJoin' => $leftJoin,
            'post' => $_POST,
            'pokja' => $pokja,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post", name="post")
     */
    public function formPost(Request $request, DataTrainingRepository $dataTrainingRepository): Response
    {
        // $leftJoin = $dataTrainingRepository->getCount("jenis_pengadaan_id", 4, 1);
        $leftJoin1 = $dataTrainingRepository->getAll();
        $pokja = $dataTrainingRepository;
        
        $jp = $request->request->get('jenis_pengadaan');
        $sd = $request->request->get('sumber_dana');
        $jk = $request->request->get('jenis_kontrak');
        $pg = $request->request->get('pagu');
        // $coba = $dataTrainingRepository->getHitung("nama_jenis_pengadaan", "jenis_pengadaan", "POKJA PEMILIHAN 212", $jp);
        // dump($coba);exit;
        return $this->render('backend/perhitungan/post.html.twig', [
            'jp' => $jp,
            'sd' => $sd,
            'jk' => $jk,
            'pg' => $pg,
            'pokja' => $pokja,
            'kmj_user' => $this->getUser()
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
            'form' => $form->createView(), 
            'title' => 'create',
            'post' => $_POST
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
