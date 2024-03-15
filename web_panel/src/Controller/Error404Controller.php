<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Error404Controller extends AbstractController
{
    
    public function renderError(Exception $exception): Response
    {
         
        $this->render('errors/error404.html.twig');
    }
}
