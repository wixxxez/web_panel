<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccountRepository; 
use App\Form\FilterAccountByState;
use Symfony\Component\HttpFoundation\Request;


class AccountController extends AbstractController
{
    #[Route('/accounts', name: 'app_account')]
    public function index(AccountRepository $repository, Request $request): Response
    {
         
        $list_of_accounts = $repository->findLastActiveAccountsLoginAndPassword();
        $form = $this->createForm(FilterAccountByState::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $state = $form->get('search')->getData();
            $list_of_accounts= $repository->filterByState($state);
        }
        return $this->render('main_work_page/account.html.twig', [
            'controller_name' => 'AccountController',
            'accounts' => $list_of_accounts,
            'form' => $form,
            'active_page' => "Account"
        ]);
    }
}
