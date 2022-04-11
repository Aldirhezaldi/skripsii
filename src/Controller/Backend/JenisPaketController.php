<?php

namespace App\Controller\Backend;

use App\Entity\JenisPaket;
use App\Form\JenisPaketType;
use App\Repository\JenisPaketRepository;
use App\Filter\JenisPaketFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;

/**
 * @Route("/jenis/paket", name="app_jenis_paket_")
 */
class JenisPaketController extends BaseController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, JenisPaketRepository $jenisPaketRepository, BreacrumbBuilder $builder): Response
    {
        $form = $this->createFormFilter(JenisPaketFilterType::class);
        $builder->add('Master');
        $builder->add('Jenis Paket');
        $queryBuilder = $this->buildFilter($request, $form, $jenisPaketRepository->createQueryBuilder('this'));
                
        return $this->render('jenis_paket/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'jenis_pakets' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView() 
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
        public function create(Request $request): Response
    {
            $jenisPaket = new JenisPaket();
                $form = $this->createForm(JenisPaketType::class, $jenisPaket, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_jenis_paket_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('jenis_paket/form.html.twig', [
            'jenis_paket' => $jenisPaket,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
        public function show(JenisPaket $jenisPaket): Response
    {
            return $this->render('jenis_paket/show.html.twig', [
            'jenis_paket' => $jenisPaket,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
        public function edit(Request $request, JenisPaket $jenisPaket): Response
    {
                    $form = $this->createForm(JenisPaketType::class, $jenisPaket, [
            'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_jenis_paket_edit', ['id' => $jenisPaket->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('jenis_paket/form.html.twig', [
            'jenis_paket' => $jenisPaket,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, JenisPaket $jenisPaket): Response
    {
        $tokenName = 'delete'.$jenisPaket->getId();
        parent::doDelete($request, $jenisPaket, $tokenName);
        
        return $this->redirectToRoute('app_jenis_paket_index');
    }
}
