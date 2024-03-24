<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;

use App\Form\ProfileImageType; 
use App\Repository\UserRepository; 
use App\Repository\AccountRepository; 
use App\Entity\User; 

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Connection $conn,Request $request, EntityManagerInterface $entityManager, UserRepository $user_repo, AccountRepository $account_repo): Response
    {
        $id = $request->query->get('id');
        $user = $user_repo->findOneByID($id); 
        $form = $this->createForm(ProfileImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$imageFile->guessExtension();

            // Resize the image if needed (example using Imagine)
            $imageFile = $form->get('image')->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $imageFile->guessExtension();

            // Move the uploaded file to the desired directory
            $imageFile->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Optionally, you can resize the image if needed
            // and remove metadata using built-in PHP functions

            // Resize the image if needed (example resizing to 200x200 pixels)
            $imagePath = $this->getParameter('images_directory') . '/' . $fileName;
             
            
            $previousFileName = $user->getProfileImage();
            if ($previousFileName && $previousFileName != 'uploads/avatars/default.png') {
                $previousFilePath =  $previousFileName;
                if (file_exists($previousFilePath)) {
                    unlink($previousFilePath);
                }
            }

            
            $user = $this->getUser();
            $user->setProfileImage($imagePath);

      
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_profile', ['id'=>$id]);
             
        }
        if ($form->isSubmitted()) {
            $this->addFlash('error', 'Invalid picture. We accept only jpg or png. ');
            return $this->redirectToRoute('app_profile', ['id'=>$id]);
       }

       if (in_array("ROLE_ADMIN", $user->getRoles())) {
        $role = "Admin";
       } 
       elseif (in_array("ROLE_MANAGER", $user->getRoles())) {
        $role = "Manager";
       } 
       else  {
        $role = "Worker";
       } 


       $user_data = $account_repo -> findAwaitedAccountsForUser($id); 
       $data = $account_repo->getAccountDetailsByDateAndWorkID($conn, date('Y-m-d'),$id );
        return $this->render('main_work_page/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'active_page' => "Account",
            'form' => $form,
            'user'=>$user,
            'role' => $role,
            'accounts' => $user_data,
            'statistics' => $data
        ]);
    }
}
