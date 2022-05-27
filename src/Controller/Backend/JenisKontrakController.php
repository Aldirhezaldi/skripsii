<?php

namespace App\Controller\Backend;

use App\Entity\JenisKontrak;
use App\Form\JenisKontrakType;
use App\Repository\JenisKontrakRepository;
use App\Filter\JenisKontrakFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/jenis/kontrak", name="app_jenis_kontrak_")
 */
class JenisKontrakController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, JenisKontrakRepository $jenisKontrakRepository, BreacrumbBuilder $builder): Response
    {
        $form = $this->createFormFilter(JenisKontrakFilterType::class);
        $builder->add('Master');
        $builder->add('Jenis Kontrak');
        $queryBuilder = $this->buildFilter($request, $form, $jenisKontrakRepository->createQueryBuilder('this'));
                
        return $this->render('jenis_kontrak/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'jenis_kontraks' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView() 
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
        public function create(Request $request): Response
    {
            $jenisKontrak = new JenisKontrak();
                $form = $this->createForm(JenisKontrakType::class, $jenisKontrak, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_jenis_kontrak_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('jenis_kontrak/form.html.twig', [
            'jenis_kontrak' => $jenisKontrak,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
        public function show(JenisKontrak $jenisKontrak): Response
    {
            return $this->render('jenis_kontrak/show.html.twig', [
            'jenis_kontrak' => $jenisKontrak,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
        public function edit(Request $request, JenisKontrak $jenisKontrak): Response
    {
                    $form = $this->createForm(JenisKontrakType::class, $jenisKontrak, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_jenis_kontrak_edit', ['id' => $jenisKontrak->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('jenis_kontrak/form.html.twig', [
            'jenis_kontrak' => $jenisKontrak,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, JenisKontrak $jenisKontrak): Response
    {
        $tokenName = 'delete'.$jenisKontrak->getId();
        parent::doDelete($request, $jenisKontrak, $tokenName);
        
        return $this->redirectToRoute('app_jenis_kontrak_index');
    }
}
