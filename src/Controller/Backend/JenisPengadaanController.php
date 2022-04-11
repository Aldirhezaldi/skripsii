<?php

namespace App\Controller\Backend;

use App\Entity\JenisPengadaan;
use App\Form\JenisPengadaanType;
use App\Repository\JenisPengadaanRepository;
use App\Filter\JenisPengadaanFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/jenis/pengadaan", name="app_jenis_pengadaan_")
 */
class JenisPengadaanController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, JenisPengadaanRepository $jenisPengadaanRepository, BreacrumbBuilder $builder): Response
    {
        $form = $this->createFormFilter(JenisPengadaanFilterType::class);
        $builder->add("Master");
        $builder->add("Jenis Pengadaan");
        $queryBuilder = $this->buildFilter($request, $form, $jenisPengadaanRepository->createQueryBuilder('this'));
                
        return $this->render('jenis_pengadaan/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'jenis_pengadaans' => parent::createPaginator($queryBuilder, $request), 
                        'filter' => $form->createView() 
                    ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
        public function create(Request $request): Response
    {
            $jenisPengadaan = new JenisPengadaan();
                $form = $this->createForm(JenisPengadaanType::class, $jenisPengadaan, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_jenis_pengadaan_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('jenis_pengadaan/form.html.twig', [
            'jenis_pengadaan' => $jenisPengadaan,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
        public function show(JenisPengadaan $jenisPengadaan): Response
    {
            return $this->render('jenis_pengadaan/show.html.twig', [
            'jenis_pengadaan' => $jenisPengadaan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
        public function edit(Request $request, JenisPengadaan $jenisPengadaan): Response
    {
                    $form = $this->createForm(JenisPengadaanType::class, $jenisPengadaan, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_jenis_pengadaan_edit', ['id' => $jenisPengadaan->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('jenis_pengadaan/form.html.twig', [
            'jenis_pengadaan' => $jenisPengadaan,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, JenisPengadaan $jenisPengadaan): Response
    {
        $tokenName = 'delete'.$jenisPengadaan->getId();
        parent::doDelete($request, $jenisPengadaan, $tokenName);
        
        return $this->redirectToRoute('app_jenis_pengadaan_index');
    }
}
