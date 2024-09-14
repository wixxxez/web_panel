<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Account;
use App\Form\AccountLogPassType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class AccountCreateController extends AbstractController
{
    #[Route('/create_account', name: 'app_account_create')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

        $account = new Account();
         
        $form = $this->createForm(AccountLogPassType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
                $account->setStatus('Active');
                $entityManager->persist($account);
                $entityManager->flush();

                // Add a success flash message
                $this->addFlash('success', 'Account created successfully!');

                // Redirect to the same page to avoid form resubmission
                return $this->redirectToRoute('app_account_create');
             
             
        }
       if ($form->isSubmitted()) {
            $this->addFlash('error', 'This login is already used.');
       }

        return $this->render('main_work_page/account_create.html.twig', [
            'controller_name' => 'AccountCreateController',
            'form' => $form,
            'active_page' => "Account"
        ]);
    }
}
