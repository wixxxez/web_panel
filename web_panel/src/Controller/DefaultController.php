<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_main_work_page');
        }

        return $this->render('main_page/index.html.twig');
    }
    

}
