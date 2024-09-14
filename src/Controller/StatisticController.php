<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\AccountRepository; 

class StatisticController extends AbstractController
{
    #[Route('/statistics', name: 'app_statistics')]
    public function index(AccountRepository $repository): Response
    {

        $list_of_accounts = $repository->findLastClosedAccounts();

        return $this->render('main_work_page/statistics.html.twig', [
            'controller_name' => 'StatisticController',
            'accounts' => $list_of_accounts,
            'active_page' => "Stat"
        ]);
    }
}
