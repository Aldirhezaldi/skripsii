<?php

namespace App\Controller\Backend;

use App\Entity\Pokja;
use App\Form\PokjaType;
use App\Repository\PokjaRepository;
use App\Filter\PokjaFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/pokja", name="app_pokja_")
 */
class PokjaController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, PokjaRepository $pokjaRepository): Response
    {
        $form = $this->createFormFilter(PokjaFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $pokjaRepository->createQueryBuilder('this'));
                
        return $this->render('pokja/index.html.twig', [
            'pokjas' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView() 
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
        public function create(Request $request): Response
    {
            $pokja = new Pokja();
                $form = $this->createForm(PokjaType::class, $pokja, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_pokja_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('pokja/form.html.twig', [
            'pokja' => $pokja,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
        public function show(Pokja $pokja): Response
    {
            return $this->render('pokja/show.html.twig', [
            'pokja' => $pokja,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
        public function edit(Request $request, Pokja $pokja): Response
    {
                    $form = $this->createForm(PokjaType::class, $pokja, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_pokja_edit', ['id' => $pokja->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('pokja/form.html.twig', [
            'pokja' => $pokja,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, Pokja $pokja): Response
    {
        $tokenName = 'delete'.$pokja->getId();
        parent::doDelete($request, $pokja, $tokenName);
        
        return $this->redirectToRoute('app_pokja_index');
    }
}
