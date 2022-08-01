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
use Phpml\Classification\NaiveBayes;
use Phpml\Dataset\CsvDataset;
use Phpml\ModelManager;

/**
 * @Route("/backend/perhitungan", name="app_backend_perhitungan_")
 */

class PerhitunganController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, BreacrumbBuilder $builder, DataTrainingRepository $dataTrainingRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $dataTesting =  new DataTesting();
        $builder->add('Perhitungan Klasifikasi');

        $pokja = $dataTrainingRepository;
        // dd($pokja->getC("nama_jenis_pengadaan", "jenis_pengadaan"));
        // dd($pokja->getPokja("POKJA PEMILIHAN 212"));
        // dd($pokja->getHitung("nama_jenis_pengadaan", "jenis_pengadaan","POKJA PEMILIHAN 212", $pokja->getC("nama_jenis_pengadaan", "jenis_pengadaan")[0]));
        $form = $this->createForm(DataTestingType::class, $dataTesting,[
            'action' => $this->generateUrl('app_backend_perhitungan_post'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // $dataTesting = $form->getData();
            $entityManagerInterface->persist($dataTesting);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_backend_perhitungan_post');
        }
        
        return $this->render('backend/perhitungan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_testing' => $dataTesting,
            'post' => $_POST,
            'pokja' => $pokja,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post", name="post")
     */
    public function formPost(Request $request, DataTrainingRepository $dataTrainingRepository, BreacrumbBuilder $builder): Response
    {
        $builder->add('Perhitungan Klasifikasi');
        $builder->add('Hasil Klasifikasi');
        $pokja = $dataTrainingRepository;
        
        $jp = $request->request->get('jenis_pengadaan');
        $sd = $request->request->get('sumber_dana');
        $jk = $request->request->get('jenis_kontrak');
        $pg = $request->request->get('pagu');

        $dataset = new CsvDataset('./dataset/NON ENCODE.csv', 4, true);

        $samples = $dataset->getSamples();
        $labels = $dataset->getTargets();

        $dttesting[] = $_POST['jenis_pengadaan'];
        $dttesting[] = $_POST['sumber_dana'];
        $dttesting[] = $_POST['jenis_kontrak'];
        $dttesting[] = $_POST['pagu'];

        $class_hasil = "";
        // dd($dttesting);
        $classifier = new NaiveBayes();
        $classifier->train($samples, $labels);
        
        $filepath = './model/model2.csv';
        
        $model = new ModelManager();
        $model->saveToFile($classifier, $filepath);

        // dd($dttesting);

        $restoredClassifier = $model->restoreFromFile($filepath);
        // dd($restoredClassifier);
        $class_hasil = $restoredClassifier->predict($dttesting);
        // dd($restoredClassifier->predict(['JASA LAINNYA', 'LAINNYA', 'WAKTU PENUGASAN', 'C']));

        return $this->render('backend/perhitungan/post.html.twig', [
            'jp' => $jp,
            'sd' => $sd,
            'jk' => $jk,
            'pg' => $pg,
            'pokja' => $pokja,
            'dttesting' => $dttesting,
            'class_hasil' => $class_hasil,
            'kmj_user' => $this->getUser()
          ]);
    }

    /**
     * @Route("/data", name="data", methods={"GET", "POST"})
     */
    public function data(Request $request, DataTrainingRepository $dataTrainingRepository, BreacrumbBuilder $builder): Response
    {
        $builder->add('Perhitungan Klasifikasi');
        $builder->add('Semua Data');

        $form = $this->createFormFilter(DataTrainingFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $dataTrainingRepository->createQueryBuilder('this'));
        return $this->render('backend/perhitungan/list_data.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_trainings' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView(),
        ]);
    }
}
