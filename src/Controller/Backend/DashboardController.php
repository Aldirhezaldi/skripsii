<?php

namespace App\Controller\Backend;

use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\UserBundle\Controller\AbstractKmjController;
use Symfony\Component\HttpFoundation\Response;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;

/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends AbstractKmjController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BreacrumbBuilder $builder)
    {
        $builder->add('dash');
        $redirectPath = $this->getRoutingConfiguration()->getLoginSuccessRedirectPath($this->getUser()->getRoles());
        
        return $this->render('backend/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'title' => 'profile', 'back_path' => $redirectPath
        ]);
    }
}
