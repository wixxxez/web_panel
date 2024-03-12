<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/accounts', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('main_work_page/account.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
