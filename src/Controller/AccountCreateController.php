<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountCreateController extends AbstractController
{
    #[Route('/account/create', name: 'app_account_create')]
    public function index(): Response
    {
        return $this->render('main_work_page/index.html.twig', [
            'controller_name' => 'AccountCreateController',
        ]);
    }
}
