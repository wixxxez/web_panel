<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\AccountRepository; 

class ArchiveController extends AbstractController
{
    #[Route('/archive', name: 'app_archive')]
    public function index(AccountRepository $repository): Response
    {

        $list_of_accounts = $repository->findLastSoldAccounts();

        return $this->render('main_work_page/archive.html.twig', [
            'controller_name' => 'ArchiveController',
            'accounts' => $list_of_accounts,
            'active_page' => "Archive"
        ]);
    }

    #[Route('/archive_delete', name: 'app_archive_delete')]
    public function delete(AccountRepository $repository): Response
    {

        $repository->removeOldAccounts();


        $this->addFlash('success', 'Old accounts have been removed'); 
        return $this->redirectToRoute('app_archive'); 
    }
}

