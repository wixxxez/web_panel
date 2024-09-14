<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\AccountRepository; 


class DeleteAccountController extends AbstractController
{
    #[Route('/delete_account', name: 'app_delete_account')]
    public function index(Request $request, AccountRepository $repository): Response
    {
        $id = $request->query->get('id');

        $repository->DeleteAccountByID($id); 

        $this->addFlash('success', "Account have been removed from database.");
        return $this->redirectToRoute('app_account');
    }
}
