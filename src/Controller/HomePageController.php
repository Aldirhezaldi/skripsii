<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController 
{
   
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        if ($this->getUser()) {
            
            return $this->redirectToRoute('home_index');
        }
        
        return $this->redirectToRoute('kmj_user_login');
    }
}
