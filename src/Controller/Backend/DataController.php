<?php

namespace App\Controller\Backend;

use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\UserBundle\Controller\AbstractKmjController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/data", name="data_")
 */
class DataController extends AbstractKmjController
{
    /**
     * @Route("/pokja", name="pokja")
     */
    public function data_pokja()
    {   
        return $this->render('backend/data_pokja.html.twig', [
            'kmj_user' => $this->getUser(),
        ]);
    }

}
