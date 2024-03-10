<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;

class MainWorkPageController extends AbstractController
{
    #[Route('/home', name: 'app_main_work_page')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Handle the case where there's no authenticated user
            return $this->redirectToRoute('login'); // Or handle it differently
        }

        $repository = $entityManager->getRepository(News::class);

        // Query to fetch the entity with type "Admin Message" and the highest ID along with the "Text" parameter
        $adminMessage = $repository->createQueryBuilder('n')
            ->select('n.Text')
            ->where('n.Type = :type')
            ->setParameter('type', 'Admin Message')
            ->orderBy('n.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        // Query to fetch the entity with type "Events" and the highest ID along with the "Text" parameter
        $events = $repository->createQueryBuilder('n')
            ->select('n.Text')
            ->where('n.Type = :type')
            ->setParameter('type', 'Events')
            ->orderBy('n.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        $news  = ['admin'=> $adminMessage, 'events' => $events];
        return $this->render('main_work_page/index.html.twig', [
            'controller_name' => 'MainWorkPageController',
            'user' => $user,
            'news' =>  $news
        ]);
    }
}
