<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteAccountController extends AbstractController
{
    #[Route('/delete/account', name: 'app_delete_account')]
    public function index(): Response
    {
        return $this->render('delete_account/index.html.twig', [
            'controller_name' => 'DeleteAccountController',
        ]);
    }
}
