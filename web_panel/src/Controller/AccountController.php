<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccountRepository; 

class AccountController extends AbstractController
{
    #[Route('/accounts', name: 'app_account')]
    public function index(AccountRepository $repository): Response
    {
         
        $list_of_accounts = $repository->findLastActiveAccountsLoginAndPassword();

        return $this->render('main_work_page/account.html.twig', [
            'controller_name' => 'AccountController',
            'accounts' => $list_of_accounts,

        ]);
    }
}
