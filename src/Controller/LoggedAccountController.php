<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\AccountRepository;
use App\Security\AppWorkerAccountConnector;
use App\Form\LoggedAccountType; 

class LoggedAccountController extends AbstractController
{
    #[Route('/fill_account_data', name: 'app_logged_account')]
    public function index(Request $request,AccountRepository $account_repo, EntityManagerInterface $entityManager): Response
    {

        $id = $request->query->get('id');

        $account = $account_repo->findOneById($id);
        $user_id = $this->getUser()->getId();
        
        $form =  $this->createForm(LoggedAccountType::class, $account);
        $security_service = new AppWorkerAccountConnector($user_id, $account_repo);
        $status = $account->getStatus();

        switch ($status) {
            case "Active" :
                if ($security_service->isUserHaveAccount())   
                {
                    $account = $account_repo->findOneByWorkerId($user_id);
                    $account_id = $account->getId();
                    if ($account_id != $id) {
                        $this->addFlash('success', 'You are already using one account!');
                        return $this->redirectToRoute('app_logged_account', ['id'=>$account_id]);
                    } 
                }   
                else {
                    $account_repo->assignWorkerId($account, $user_id);
                }
                break;
            
            case in_array($status, ['Processing',"Closed"]):
                if ($security_service->checkAccess($id) == False)
                {
                    $this->addFlash('error', 'Ooops. you dont have access to see this account.');
                    
                    return $this->redirectToRoute('app_account');
                }
                break;
                    
        }
         
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
             
            $entityManager->persist($account);
             
            $entityManager->flush();
            
            $account_repo->deactivateAccount($account, "Closed");
            $this->addFlash('success', 'Good job! Data transfered succesfully.');
             
            return $this->redirectToRoute('app_account');
        }

          

        return $this->render('main_work_page/logged_account.html.twig', [
            'controller_name' => 'LoggedAccountController',
            'account' => $account,
            'form' => $form,
            'active_page' => "Account"
        ]);
    }

    #[Route('/cancel_filling_account', name: 'app_logged_account_cancel')]
    public function cancel(Request $request,AccountRepository $account_repo, EntityManagerInterface $entityManager): Response
    {
        $id = $request->query->get('id');
        $account = $account_repo->findOneById($id);
        $account_repo->deactivateAccount($account, "Active");

        return $this->redirectToRoute('app_account');
    }
}
