<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\UserController;

class UserDetailsController extends AbstractController
{
    
    //user details render view page
    #[Route('/user/details', name: 'app_user_details')]
    public function index(): Response
    {
        return $this->render('user_details/index.html.twig', [
            'controller_name' => 'UserDetailsController',
        ]);
    }
    
    //get user information form parent class string function page render
    #[Route('/user_info', name: 'user_info')]
    public function UserInfo(UserController $user): Response
    {   
            $response=$user->string();
            
            return $response;
    }
    //get the user parent page call form child controller to prent userPage function
    #[Route('/user_parent_page', name: 'user_parent_page')]
    public function userPage(UserController $user): Response
    {   
            $response=$user->userPage();
            
            return $response;
    }
    // file download function get the dwonload functionlity form the user tables
    #[Route('/user_file_download', name: 'user_file_download')]
    public function download(UserController $user): Response
    {       $path="/path/to/some_file.pdf1";
            $response=$user->download($path);
            
            return $response;
    }
}
