<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registration", name="app_registration_")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="regis")
     */
    public function index(): Response
    {
        $form = $this->createForm(RegistrationType::class);
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView(),
        ]);
    }
}
