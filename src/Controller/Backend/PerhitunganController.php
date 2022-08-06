<?php

namespace App\Controller\Backend;

use App\Repository\DataTrainingRepository;
use App\Entity\DataTraining;
use App\Entity\DtTesting;
use App\Entity\JenisPengadaan;
use App\Form\DataTestingType;
use App\Repository\PokjaRepository;
use App\Filter\DtTestingFilterType;
use App\Form\DtTestingType;
use App\Repository\DtTestingRepository;
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
        $dataTesting =  new DtTesting();
        $builder->add('Perhitungan Klasifikasi');

        $pokja = $dataTrainingRepository;
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
    public function formPost(Request $request, DataTrainingController $dataTrainingController , DataTrainingRepository $dataTrainingRepository, BreacrumbBuilder $builder): Response
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

    /**
     * @Route("/list_testing", name="list_testing", methods={"GET", "POST"})
     */
    public function listTesting(Request $request, DtTestingRepository $dtTestingRepository, BreacrumbBuilder $builder): Response
    {
        $builder->add('Semua Data testing');

        $form = $this->createFormFilter(DtTestingFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $dtTestingRepository->createQueryBuilder('this'));
        return $this->render('backend/perhitungan/list_testing.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_test' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $dtTesting = new DtTesting();
        
        $form = $this->createForm(DtTestingType::class, $dtTesting, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_backend_perhitungan_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('backend/perhitungan/form_create.html.twig', [
            'dt_testing' => $dtTesting,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
    public function show(DtTesting $dtTesting): Response
    {
        return $this->render('backend/perhitungan/show_testing.html.twig', [
            'dtTesting' => $dtTesting,
        ]);
    }

    /**
     * @Route("/{id}/klasifikasi", name="klasifikasi", methods={"GET"})
     */
    public function klasifikasi($id, Request $request, DtTesting $dtTesting, DataTrainingRepository $dataTrainingRepository): Response
    {

        $pokja = $dataTrainingRepository;

        $tes = [
            $jp = [strval($dtTesting->getJenisPengadaan())][0],
            $sd = [strval($dtTesting->getSumberDana())][0],
            $jk = [strval($dtTesting->getJenisKontrak())][0],
            $pg = [strval($dtTesting->getPagu())][0],
        ];

        return $this->render('backend/perhitungan/klasifikasi.html.twig', [
            'kmj_user' => $this->getUser(),
            'id' => $id,
            'jp' => $jp,
            'sd' => $sd,
            'jk' => $jk,
            'pg' => $pg,
            'pokja' => $pokja,
            'dtTesting' => $dtTesting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DtTesting $dtTesting): Response
    {
        $form = $this->createForm(DtTestingType::class, $dtTesting, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_backend_perhitungan_edit', ['id' => $dtTesting->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('backend/perhitungan/form_create.html.twig', [
            'dtTesting' => $dtTesting,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, DtTesting $dtTesting): Response
    {
        $tokenName = 'delete'.$dtTesting->getId();
        parent::doDelete($request, $dtTesting, $tokenName);
        
        return $this->redirectToRoute('app_backend_perhitungan_list_testing');
    }
}
