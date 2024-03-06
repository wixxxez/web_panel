<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainWorkPageController extends AbstractController
{
    #[Route('/home', name: 'app_main_work_page')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Handle the case where there's no authenticated user
            return $this->redirectToRoute('login'); // Or handle it differently
        }

        return $this->render('main_work_page/index.html.twig', [
            'controller_name' => 'MainWorkPageController',
            'user' => $user,
        ]);
    }
}
