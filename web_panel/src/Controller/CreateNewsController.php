<?php

// src/Controller/NewsController.php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CreateNewsController extends AbstractController
{
     

    #[Route('/create_news', name: 'app_create_news')]
    public function new(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $type = $request->query->get('type');

        $news = new News();
        $news->setType($type);
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
         
        if ($form->isSubmitted() ) {
           
             
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('app_main_work_page');
        }

        return $this->render('main_work_page/create_news.html.twig', [
            'news' => $news,
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }
}


?>