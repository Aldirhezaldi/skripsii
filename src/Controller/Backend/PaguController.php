<?php

namespace App\Controller\Backend;

use App\Entity\Pagu;
use App\Form\PaguType;
use App\Repository\PaguRepository;
use App\Filter\PaguFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/pagu", name="app_pagu_")
 */
class PaguController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, PaguRepository $paguRepository): Response
    {
                $form = $this->createFormFilter(PaguFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $paguRepository->createQueryBuilder('this'));
                
        return $this->render('pagu/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'pagus' => parent::createPaginator($queryBuilder, $request), 
                        'filter' => $form->createView() 
                    ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
        public function create(Request $request): Response
    {
            $pagu = new Pagu();
                $form = $this->createForm(PaguType::class, $pagu,[
                    'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_pagu_create')]
                ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('pagu/form.html.twig', [
            'pagu' => $pagu,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
        public function show(Pagu $pagu): Response
    {
            return $this->render('pagu/show.html.twig', [
            'pagu' => $pagu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
        public function edit(Request $request, Pagu $pagu): Response
    {
                    $form = $this->createForm(PaguType::class, $pagu);
        $result = parent::processForm($request, $form);
        if ($result) {
            return $this->redirectToRoute('app_pagu_index');
        }
         
        return $this->render('pagu/form.html.twig', [
            'pagu' => $pagu,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, Pagu $pagu): Response
    {
        $tokenName = 'delete'.$pagu->getId();
        parent::doDelete($request, $pagu, $tokenName);
        
        return $this->redirectToRoute('app_pagu_index');
    }
}
