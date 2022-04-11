<?php

namespace App\Controller\Backend;

use App\Entity\SumberDana;
use App\Form\SumberDanaType;
use App\Repository\SumberDanaRepository;
use App\Filter\SumberDanaFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/sumber/dana", name="app_sumber_dana_")
 */
class SumberDanaController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, SumberDanaRepository $sumberDanaRepository, BreacrumbBuilder $builder): Response
    {
        $form = $this->createFormFilter(SumberDanaFilterType::class);
        $builder->add("Master");
        $builder->add("Sumber Dana");
        $queryBuilder = $this->buildFilter($request, $form, $sumberDanaRepository->createQueryBuilder('this'));
                
        return $this->render('sumber_dana/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'sumber_danas' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView() 
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $sumberDana = new SumberDana();
        $form = $this->createForm(SumberDanaType::class, $sumberDana, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_sumber_dana_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('sumber_dana/form.html.twig', [
            'sumber_dana' => $sumberDana,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
        public function show(SumberDana $sumberDana): Response
    {
            return $this->render('sumber_dana/show.html.twig', [
            'sumber_dana' => $sumberDana,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
        public function edit(Request $request, SumberDana $sumberDana): Response
        {
        $form = $this->createForm(SumberDanaType::class, $sumberDana, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_sumber_dana_edit', ['id' => $sumberDana->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('sumber_dana/form.html.twig', [
            'sumber_dana' => $sumberDana,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, SumberDana $sumberDana): Response
    {
        $tokenName = 'delete'.$sumberDana->getId();
        parent::doDelete($request, $sumberDana, $tokenName);
        
        return $this->redirectToRoute('app_sumber_dana_index');
    }
}
