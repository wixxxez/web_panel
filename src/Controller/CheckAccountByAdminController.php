<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\AccountRepository;
use App\Security\AccountAdminMiddleware;
use App\Form\SellAccountType;


class CheckAccountByAdminController extends AbstractController
{
    #[Route('/check_account_by_admin', name: 'app_check_account_by_admin')]
    public function index(Request $request, AccountRepository $account_repo, EntityManagerInterface $entityManager): Response
    {
        $id = $request->query->get('id');
        $account = $account_repo->findOneById($id);

        $user_id = $this->getUser()->getId();

        $middleware = new AccountAdminMiddleware($account, $account_repo, $user_id);


        $status = $account->getAdminEvent();

        switch ($status) {
            case "Await" :
                if ($middleware->isAdminHaveAccount())   
                {
                    $account = $account_repo->findOneByAdminId($user_id);
                    $account_id = $account->getId();
                    if ($account_id != $id) {
                        $this->addFlash('error', 'You are already checking one account!');
                        return $this->redirectToRoute('app_check_account_by_admin', ['id'=>$account_id]);
                    } 
                }   
                else {
                    $account_repo->assignAdminId($account, $user_id);
                }
                break;
            
            case "In progress":
                if ($middleware->checkAccess($id) == False)
                {
                    $this->addFlash('error', 'Ooops. This account are already check by other admin.');
                    
                    return $this->redirectToRoute('app_statistics');
                }
                break;
            
            case "Sold":
                
                $this->addFlash('error', 'This account have been sold.');
                    
                return $this->redirectToRoute('app_statistics');
                break; 
        }


        $form = $this->createForm(SellAccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $sell = $form->get('sell')->getData();
            $account->setPaid($sell * 0.1);
            $account->setAdminEvent('Sold');
            $entityManager->persist($account);
            $entityManager->flush();

            // Add a success flash message
            $this->addFlash('success', 'Account have been sold!');

            // Redirect to the same page to avoid form resubmission
            return $this->redirectToRoute('app_statistics');
        }
        return $this->render('main_work_page/check_account.html.twig', [
            'controller_name' => 'CheckAccountByAdminController',
            'account' => $account,
            'form' => $form
        ]);
    }

    #[Route('/check_account_by_admin_cancel', name: 'app_check_account_by_admin_cancel')]
    public function check_account_by_admin_cancel(Request $request, AccountRepository $account_repo) 
    {
        $id = $request->query->get('id');
        
        
        $account = $account_repo->findOneById($id);
        $account_repo->deactivateAccountByAdmin($account, "Await");

        return $this->redirectToRoute('app_statistics');
    }
}
