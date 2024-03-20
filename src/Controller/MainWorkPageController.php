<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;
use App\Repository\NewsRepository;
use App\Repository\AccountRepository;
 
use Doctrine\DBAL\Connection;
class MainWorkPageController extends AbstractController
{
    #[Route('/home', name: 'app_main_work_page')]
    public function index(NewsRepository $news_repository, AccountRepository $repository, Connection $conn): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Handle the case where there's no authenticated user
            return $this->redirectToRoute('login'); // Or handle it differently
        }

         

        // Query to fetch the entity with type "Admin Message" and the highest ID along with the "Text" parameter
        $adminMessage = $news_repository->GetLastAdminMessage();

        $events = $news_repository->GetLastEventMessage();
         
        $data =  $repository->getAccountDetailsByDate($conn, date('Y-m-d'));
        $news  = ['admin'=> $adminMessage, 'events' => $events];
        return $this->render('main_work_page/index.html.twig', [
            'controller_name' => 'MainWorkPageController',
            'user' => $user,
            'news' =>  $news,
            "user_data" => $data
        ]);
    }
}
