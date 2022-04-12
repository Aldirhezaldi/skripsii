<?php

namespace App\Controller\Backend;

use App\Entity\DataTraining;
use App\Form\DataTrainingType;
use App\Repository\DataTrainingRepository;
use App\Filter\DataTrainingFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/data/training", name="app_data_training_")
 */
class DataTrainingController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, DataTrainingRepository $dataTrainingRepository): Response
    {
        $form = $this->createFormFilter(DataTrainingFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $dataTrainingRepository->createQueryBuilder('this'));
                
        return $this->render('data_training/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_trainings' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView() 
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $dataTraining = new DataTraining();
        $form = $this->createForm(DataTrainingType::class, $dataTraining, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_data_training_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('data_training/form.html.twig', [
            'data_training' => $dataTraining,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
    public function show(DataTraining $dataTraining): Response
    {
        return $this->render('data_training/show.html.twig', [
            'data_training' => $dataTraining,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DataTraining $dataTraining): Response
    {
        $form = $this->createForm(DataTrainingType::class, $dataTraining, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_data_training_edit', ['id' => $dataTraining->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('data_training/form.html.twig', [
            'data_training' => $dataTraining,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, DataTraining $dataTraining): Response
    {
        $tokenName = 'delete'.$dataTraining->getId();
        parent::doDelete($request, $dataTraining, $tokenName);
        
        return $this->redirectToRoute('app_data_training_index');
    }
}
