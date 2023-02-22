<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserGroupController extends AbstractController
{
    #[Route('/group', name: 'app_user_group')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserGroupController.php',
        ]);
    }
    #[Route('/role', name: 'app_user_role_group')]
    public function role(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserGroupController.php',
        ]);
    }
    
    #[Route('/contact', name: 'app_user_contact_group')]
    public function contact(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserGroupController.php',
        ]);
    }
    #[Route('/test', name: 'app_user_contact_group')]
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new test controller!',
            'path' => 'src/Controller/UserGroupController.php',
        ]);
    }
}
